<?php


namespace App\Helpers;


class ListingHelper
{
    private $perPage = '10';
    private $sortBy = 'desc';
    private $sortByField = 'updated_at';
    private $filterFields = [];
    private $requiredConditions = [];
    private $customQueries = [];
    private $customQueryFields = [];
    private $leftJoinTables = [];

    public function sort_by($sortByField, $sortBy = 'desc')
    {
        $this->sortByField = $sortByField;
        $this->sortBy = $sortBy;

        return $this;
    }

    public function per_page($perPage)
    {
        $this->perPage = $perPage;

        return $this;
    }

    public function filter_fields(Array $fields)
    {
        $this->filterFields = $fields;

        return $this;
    }

    public function required_condition($field, $operator, $value)
    {
        $this->requiredConditions[] = [
            'field' => $field,
            'operator' => $operator,
            'value' => $value
        ];

        return $this;
    }

    public function custom_queries($customQueries, $customQueryFields)
    {
        $this->customQueries = $customQueries;
        $this->customQueryFields = $customQueryFields;

        return $this;
    }

    public function left_join($name, $field1, $field2)
    {
        $this->leftJoinTables[] = [
            'name' => $name,
            'field1' => $field1,
            'field2' => $field2
        ];

        return $this;
    }

    public function simple_search($model, $searchFields)
    {
        $sortFields =  (empty($this->filterFields)) ? $searchFields : $this->filterFields;

        $perPage = $this->get_count_per_page();
        $orderBy = $this->get_selected_order_by($sortFields);
        $sortBy = $this->get_selected_sort_by();
        $showDeleted = $this->show_delete_data();
        $search =  $this->get_search_string();

        $requiredConditions = $this->requiredConditions;
        $customQueries = $this->customQueries;
        $customQueryFields = $this->customQueryFields;
        $joinTables = $this->leftJoinTables;

        $models = $model::orderBy($orderBy, $sortBy);

        foreach ($joinTables as $table) {
            $models->leftJoin($table['name'], $table['field1'], $table['field2']);
        }

        if ($showDeleted) {
            $models->withTrashed();
        }

        foreach ($requiredConditions as $condition) {
            $models->where($condition['field'], $condition['operator'], $condition['value']);
        }

        $models->where(function($models) use ($search, $searchFields, $customQueries, $customQueryFields) {
            foreach ($searchFields as $fieldName) {
                if (in_array($fieldName, $customQueryFields) <= -1) {
                    $models->orWhere($fieldName, 'like', '%' . $search . '%');
                }
            }

            foreach ($customQueries as $query) {
                $models->orWhereRaw($query, ['%' . $search . '%']);
            }
        });

        $this->reset_static_data();

        return $models->paginate($perPage);
    }

    public function simple_search_trash_only($model, $searchFields)
    {
        $sortFields =  (empty($this->filterFields)) ? $searchFields : $this->filterFields;

        $perPage = $this->get_count_per_page();
        $orderBy = $this->get_selected_order_by($sortFields);
        $sortBy = $this->get_selected_sort_by();
        $search =  $this->get_search_string();

        $requiredConditions = $this->requiredConditions;
        $customQueries = $this->customQueries;
        $customQueryFields = $this->customQueryFields;
        $joinTables = $this->leftJoinTables;

        $models = $model::onlyTrashed()->orderBy($orderBy, $sortBy);

        foreach ($joinTables as $table) {
            $models->leftJoin($table['name'], $table['field1'], $table['field2']);
        }

        foreach ($requiredConditions as $condition) {
            $models->where($condition['field'], $condition['operator'], $condition['value']);
        }

        $models->where(function($models) use ($search, $searchFields, $customQueries, $customQueryFields) {
            foreach ($searchFields as $fieldName) {
                if (in_array($fieldName, $customQueryFields) <= -1) {
                    $models->orWhere($fieldName, 'like', '%' . $search . '%');
                }
            }

            foreach ($customQueries as $query) {
                $models->orWhereRaw($query, ['%' . $search . '%']);
            }
        });

        return $models->paginate($perPage);
    }

    public function advance_search($model, $searchFields, $equalSearchFields)
    {
        $searchFields = $this->get_search_filtered($searchFields);
        $sortFields =  (empty($this->filterFields)) ? $searchFields : $this->filterFields;

        $perPage = $this->get_count_per_page();
        $orderBy = $this->get_selected_order_by($sortFields);
        $sortBy = $this->get_selected_sort_by();
        $showDeleted = $this->show_delete_data();

        if ($showDeleted) {
            $queryBuilder = $model::withTrashed();
        } else {
            $queryBuilder = $model::whereNotNull('id');
        }

        foreach ($equalSearchFields as $fieldName) {
            if (isset($searchFields['created_at1'])) {
                $queryBuilder->where('created_at', '>=', $searchFields['created_at1']);

                unset($searchFields['created_at1']);
            } elseif (isset($searchFields['created_at2'])) {
                $queryBuilder->where('created_at', '<=', $searchFields['created_at2'].' 23:59:59');

                unset($searchFields['created_at2']);
            } else if (isset($searchFields['updated_at1'])) {
                $queryBuilder->where('updated_at', '>=', $searchFields['updated_at1']);

                unset($searchFields['updated_at1']);
            } elseif (isset($searchFields['updated_at2'])) {
                $queryBuilder->where('updated_at', '<=', $searchFields['updated_at2'].' 23:59:59');

                unset($searchFields['updated_at2']);
            } else {
//                dd($searchFields);
                if (isset($searchFields[$fieldName])) {
                    $field_value = $searchFields[$fieldName];

                    if ($field_value == '#^!!') {
                        $queryBuilder->whereNull($fieldName);
                        unset($searchFields[$fieldName]);
                    } else {
                        $queryBuilder->where($fieldName, $field_value);
                        unset($searchFields[$fieldName]);
                    }
                }
            }
        }

        foreach ($searchFields as $fieldName => $field_value) {
            if ($field_value == '#^!!') {
                $queryBuilder->whereNull($fieldName);
                continue;
            }
            $queryBuilder->where($fieldName, 'like', '%'.$field_value.'%');
        }

        return $queryBuilder->orderBy($orderBy, $sortBy)->paginate($perPage);
    }

    public function get_unique_item_by_column($model, $columnName)
    {
        if ($this->show_delete_data()) {
            return $model::withTrashed()->get()->unique($columnName)->values()->all();
        } else {
            return $model::get()->unique($columnName)->values()->all();
        }
    }

    public function get_filter($searchFields)
    {
        $sortFields =  (empty($this->filterFields)) ? $searchFields : $this->filterFields;

        $parameters = request()->all();
        $parameters['perPage'] = $this->get_count_per_page();
        $parameters['orderBy'] = $this->get_selected_order_by($sortFields);
        $parameters['sortBy'] = $this->get_selected_sort_by();
        $parameters['showDeleted'] = $this->show_delete_data();
        $parameters['search'] = $this->get_search_string();

        return (object) $parameters;
    }

    public function get_search_filtered($searchFields)
    {
        return array_filter($this->credentials($searchFields), function ($value, $key) {
            return $value != null && $key != '_token';
        }, ARRAY_FILTER_USE_BOTH);
    }

    public function get_search_data($searchFields)
    {
        $arrayData = array_map(function ($key) {
            if (request()->has($key) && request()->$key != null) {
                return [$key => request()->$key];
            } else {
                return[$key => ''];
            }
        }, $searchFields);

        $searchData = [];
        foreach ($arrayData as $data) {
            $searchData[key($data)] = $data[key($data)];
        }

        return (object) $searchData;
    }

    private function credentials($searhFields)
    {
        return request()->only($searhFields);
    }

    private function get_count_per_page()
    {
        $perPage = request()->has('perPage') && is_numeric(request('perPage')) ? request('perPage') : $this->perPage;
        return ($perPage > 100) ? 100 : $perPage;
    }

    private function get_selected_order_by($searchFields)
    {
        return request()->has('orderBy') && in_array(request('orderBy'), $searchFields) ? request('orderBy') : $this->sortByField;
    }

    private function get_selected_sort_by()
    {
        $sortBy = request('sortBy') ?? $this->sortBy;
        return $sortBy == 'asc' ? 'asc' : 'desc';
    }

    private function get_search_string()
    {
        return request('search') ?? '';
    }

    private function show_delete_data()
    {
        return (request()->has('showDeleted') && (request('showDeleted') == 'on') || request('showDeleted') == 1) ? true : false;
    }

    private function reset_static_data()
    {
        $this->perPage = '10';
        $this->sortBy = 'desc';
        $this->sortByField = 'updated_at';
        $this->filterFields = [];
        $this->requiredConditions = [];
        $this->customQueries = [];
        $this->customQueryFields = [];
        $this->leftJoinTables = [];
    }
}

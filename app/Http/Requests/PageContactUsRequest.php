<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageContactUsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'meta_title' => 'SEO Title',
            'meta_description' => 'SEO Description',
            'meta_keyword' => 'SEO Keywords',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'album_id' => 'nullable|exists:albums,id',
            'name' => 'required|max:150',
            'label' => 'required|max:150',
            'contents' => '',
            'emails' => function ($attribute, $value, $fail) {
                if (empty($value)) {
                    $fail('The email recipients field is required.');
                } else {
                    $emails = explode(',', $value);

                    $invalidEmails = [];
                    foreach ($emails as $email) {
                        if (!filter_var( $email, FILTER_VALIDATE_EMAIL )) {
                            $invalidEmails[] = $email;
                        }
                    }

                    if (count($invalidEmails)) {
                        $lastIndex = count($invalidEmails) - 1;

                        if ($lastIndex == 0) {
                            $fail($email . ' is invalid email.');
                        } else {
                            $lastEmail = $invalidEmails[$lastIndex];
                            unset($invalidEmails[$lastIndex]);
                            $emails = implode(', ', $invalidEmails);
                            $fail($emails . ' and ' . $lastEmail . ' are invalid email.');
                        }
                    }
                }
            },
            'content2' => 'required',
            'image_url' => 'nullable',
            'visibility' => '',
            'meta_title' => 'max:60',
            'meta_description' => 'max:160',
            'meta_keyword' => 'max:160',
        ];
    }
}

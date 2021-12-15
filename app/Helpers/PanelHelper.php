<?php


namespace App\Helpers;

use Illuminate\Support\Facades\Route;

class PanelHelper
{
    public static function get_routes()
    {
        $panelName = env('APP_PANEL', 'cerebro');
        $routes = [];

        foreach (Route::getRoutes() as $key => $route)
        {
            if (self::is_panel_routes($route, $panelName)) {
                $routes[] = $route;
            }
        }

        return $routes;
    }

    /**
     * @param $route
     * @param $panelName
     * @return bool
     */
    private static function is_panel_routes($route, $panelName): bool
    {
        return strpos($route->getPrefix(), $panelName) !== false && in_array('admin', $route->middleware());
    }
}

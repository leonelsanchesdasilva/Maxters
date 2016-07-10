<?php

namespace Maxters\Controllers\Debug;

use Maxters\Controllers\Controller;

class DebugController extends Controller
{

    public function actionIndexGet()
    {
        return $this->render('_debug/index');
    }

    public function actionInfosGet()
    {
        return $this->render('_debug/infos', ['app' => $this]);
    }

    public function actionAjaxInfosGet()
    {

        $infos = [];

        foreach ($this->app->keys() as $key) {

            if (is_object($this->app[$key])) {

                $infos[$key] = get_class($this->app[$key]);

            } else {

                $infos[$key] = var_export($this->app[$key], true);
            }
        }

        return $infos;
    }

    public function actionAjaxRoutesGet()
    {
        $routes = $this->app['router']->getCollection()->map(function ($route) {

            return [
                'pattern' => $route->getPattern() ?: '/',
                'name'    => $route->getName(),
                'verbs'   => $route->getVerbs(),
                'action'  => $route->getActionName() . ' ()'
            ];

        })->sortBy(function ($info) {
            
            return $info['pattern'];
        });

        return $routes->toArray();
    }
}

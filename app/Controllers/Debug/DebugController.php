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
        foreach ($this->app['router']->getCollection() as $route) {

            $action = $route->getAction();

            $response[] = [
                'pattern' => $route->getPattern() ?: '/',
                'name'    => $route->getName(),
                'verbs'   => $route->getVerbs(),
                'action'  => $action instanceof \Closure ? 'Closure' : implode('::', $action) . '()'
            ];
        }

        usort($response, function ($a, $b) {

            return $a['pattern'] - $b['pattern'];
        });

        return $response;
    }
}

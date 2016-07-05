<?php

namespace Maxters\Controllers;

use Maxters\Models\User;
use Maxters\Models\UserQuery;
use PHPLegends\Http\Exceptions\NotFoundException;

class UsersController extends Controller
{
    public function actionIndexGet()
    {
        return $this->render('users/index', compact('users'));
    }

    public function actionAjaxListGet($page = 1)
    {
        $users = UserQuery::create()->paginate($page, 15);

        return $users->toArray();
    }

    public function actionAjaxCreatePost()
    {
        $request = $this->request()->getBody();

        return ['post' => $request->all(), 'json' => $this->request()->getContent()];
    }

    public function getAjaxInfo($id)
    {
        $user = UserQuery::create()->findPK($id);

        \Maxters\http_error_when(!$user, 'User not found', 404);

        return $user->toArray();
    }
}

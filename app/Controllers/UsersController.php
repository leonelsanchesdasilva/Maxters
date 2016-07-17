<?php

namespace Maxters\Controllers;

use Maxters\Models\User;
use PHPLegends\Http\Exceptions\NotFoundException;

class UsersController extends Controller
{
    public function actionIndexGet()
    {
        return $this->render('users/index', compact('users'));
    }

    public function actionAjaxListGet($offset = 0)
    {

        return $this->entityMapper('Maxters\Models\User')
                    ->all()
                    ->limit($limit = 10, $offset * $limit)
                    ->toArray();
    }

    public function actionAjaxCreatePost()
    {
        $data = $this->request()->getJsonContent();

        $user = new User($data);

        $this->entityMapper('Maxters\Models\User')->save($user);

        return $user->toArray();

    }

    /**
     *
     * @param int $id
     * @return array
     * */
    public function actionAjaxInfoGet($id)
    {
        $user = $this->entityMapper('Maxters\Models\User')->first(compact('id'));

        \Maxters\http_error_when(!$user, 'User not found', 404);

        return $user->toArray();
    }
}

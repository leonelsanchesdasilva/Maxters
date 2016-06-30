<?php

namespace Maxters\Controllers;

use Maxters\Models\User;
use Maxters\Models\UserQuery;
use PHPLegends\Http\Exceptions\NotFoundException;

class UsersController extends Controller
{
    public function getAjaxInfo($id)
    {
        $user = UserQuery::create()->findPK($id);

        \Maxters\http_error_when(!$user, 'User not found', 404);

        return $user->toArray();
    }
}

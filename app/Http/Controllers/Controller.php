<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Determine whether user is authorized for given ability
     *
     * @param $ability
     * @param $model
     * @param string $message
     * @throws AuthorizationException
     */
    protected function isAuthorized($ability, $model, $message = 'You are not authorized for this action')
    {
        if(Gate::denies($ability, $model))
        {
            throw new AuthorizationException($message);
        }
    }
}

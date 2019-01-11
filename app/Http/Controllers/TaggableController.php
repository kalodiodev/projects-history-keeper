<?php

namespace App\Http\Controllers;

abstract class TaggableController extends Controller
{
    /**
     * Get selected tag
     *
     * @return null
     */
    protected function activeTag()
    {
        if(request()->has('tag')) {
            return request('tag');
        }

        return null;
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\FeedSource;
use Illuminate\Routing\Controller as BaseOneController;
use Illuminate\Http\Request;

class BaseController extends BaseOneController
{

    protected function sendResponse($content)
    {
        return response($content)
            ->header('Content-Type', 'application/json');
    }

}

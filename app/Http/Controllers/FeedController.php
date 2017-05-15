<?php

namespace App\Http\Controllers;

use App\Models\Feed;
use Illuminate\Http\Request;

class FeedController extends BaseController
{

    public function getAll(Request $request)
    {
        $result = Feed::getPagiated($request->get('page'));

        return $this->sendResponse(json_encode($result));
    }

}

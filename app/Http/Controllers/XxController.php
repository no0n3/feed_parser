<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class XxController extends BaseController
{
    
    public function index(\App\Components\Feed $f, Request $r) {
    	var_dump($f);
    	echo "LQLQ##";
    }
}

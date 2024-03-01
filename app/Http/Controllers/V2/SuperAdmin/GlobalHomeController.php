<?php

namespace App\Http\Controllers\V2\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Services\SiteAdmin\GlobalHomeService;
use Illuminate\Http\Request;

class GlobalHomeController extends Controller
{
    private $service;

    public function __construct(GlobalHomeService $service)
    {
        $this->service = $service;
    }
    public function index()
    {
        $users =  $this->service->users();
        view()->share('users', $users);
        return view('site-admins.index');
    }

}

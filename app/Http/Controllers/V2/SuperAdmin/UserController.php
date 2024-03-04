<?php

namespace App\Http\Controllers\V2\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\SiteAdmin\GlobalHomeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $service;

    public function __construct(GlobalHomeService $service)
    {
        $this->service = $service;
    }
    public function create()
    {
        if (auth()->user()->role != 1)
        {
            abort(403);
        }
        return view('site-admins.users.store');
    }

    public function store(Request $request)
    {
        $users =  $this->service->users();
        view()->share('users', $users);
        User::create([
            'first_name'       => $request->first_name,
            'last_name'        => $request->last_name,
            'username'         => $request->first_name .'_'. $request->last_name,
            'email'            => $request->email,
            'password'         => Hash::make($request->password),
            'phone'            => $request->phone,
            'role'             => $request->role,
        ]);
        return redirect('site-admin/settings');
    }

    public function edit($id)
    {
        if (auth()->user()->role != 1)
        {
            abort(403);
        }
        $user = User::findOrFail($id);
        return view('site-admins.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->role != 1)
        {
            abort(403);
        }
        $user = User::findOrFail($id);
        $user->update([
            'first_name'       => $request->first_name,
            'last_name'        => $request->last_name,
            'username'         => $request->first_name .'_'. $request->last_name,
            'email'            => $request->email,
            'phone'            => $request->phone,
            'role'             => $request->role,
            'status'           => $request->status,
        ]);
        $users =  $this->service->users();
        view()->share('users', $users);
        return redirect('site-admin/settings');
    }
}

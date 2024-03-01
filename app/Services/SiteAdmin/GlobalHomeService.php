<?php

namespace App\Services\SiteAdmin;

use App\Models\User;

class GlobalHomeService
{
    public function users()
    {
        return User::where('id', '!=', auth()->user()->id)
            ->get();
    }
}

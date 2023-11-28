<?php


namespace App\Services\SiteActivity;


use App\Models\SiteActivity;

class SiteActivityService
{
    public function listAll()
    {
        return SiteActivity::query()
            ->with('user')
            ->orderByDesc('created_at');
    }
}

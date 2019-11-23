<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DomainResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Get user with all his domains.
     * 
     * @param  \App\Http\Requests\Request  $request
     * 
     * @return \App\Http\Resources\UserResource
     */
    public function getUser(Request $request) {
        return UserResource::make($request->user()->with('domains'));
    }

    /**
     * Get all domains of authenticated user.
     * 
     * @param \App\Http\Requests\Request  $request
     * 
     * @return App\Http\Resources\DomainResource
     */
    public function getDomains(Request $request) {
        return $request->user()->domains();
    }
}

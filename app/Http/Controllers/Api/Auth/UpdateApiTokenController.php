<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UpdateApiTokenController extends Controller
{
    /**
     * Update API token.
     * 
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return array
     */
    public function update(Request $request) {
        $token = $request->user()->updateApiToken();
        return [ 'token' => $token ];
    }
}

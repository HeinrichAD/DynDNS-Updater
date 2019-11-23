<?php

namespace App\Http\Controllers;

use App\DynDNS\Connect;
use App\Http\Controllers\Controller;
use App\Http\Requests\DynDnsAccessCodeRequest;
use App\Http\Requests\DynDnsBaseRequest;
use App\Http\Requests\DynDnsRedirectRequest;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;

class DynDnsController extends Controller
{
    use RedirectsUsers;

    /**
     * Where to redirect users when the intended url fails.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    
    /**
     * Setup DynDNS for given 1&1 domain.
     * 
     * @param \App\Http\Requests\DynDnsRedirectRequest  $request
     * 
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function setup(DynDnsRedirectRequest $request) {
        $domain = $request->input('domain');
        $accessCode = $request->input('accessCode');
        
        try {
            if (Connect::setup($domain, $accessCode)) {
                $request->session()->flash(
                    'status', 
                    "The setup for the domain '$domain' was successful!"
                );
            }
            else {
                $request->session()->flash(
                    'error',
                    "The setup for the domain '$domain' has failed!"
                );
            }
            return redirect()->intended($this->redirectPath());
        }
        catch (ProcessFailedException $ex) {
            abort(500, $ex->getMessage());
        }
    }
}
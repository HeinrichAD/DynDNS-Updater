<?php

namespace App\Http\Controllers\Api;

use App\DynDNS\Connect;
use App\Http\Controllers\Controller;
use App\Http\Requests\DynDnsAccessCodeRequest;
use App\Http\Requests\DynDnsBaseRequest;
use App\Http\Requests\DynDnsRedirectRequest;
use Illuminate\Http\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;

class DynDnsController extends Controller
{
    /**
     * Get activation url for given 1&1 domain.
     * 
     * @param  \App\Http\Requests\DynDnsRedirectRequest  $request
     * 
     * @return \Illuminate\Http\RedirectResponse|string  redirect or activation url
     */
    public function getActivationUrl(DynDnsRedirectRequest $request) {
        $domain = $request->input('domain');
        $redirect = $request->input('redirect');
        $url = Connect::getActivationUrl($domain);

        if (!$redirect) {
            return $url;
        }
        return Redirect::to($url);
    }

    /**
     * Setup DynDNS for given 1&1 domain.
     * 
     * @param \App\Http\Requests\DynDnsRedirectRequest  $request
     * 
     * @return string success state (boolean as string)
     */
    public function setup(DynDnsAccessCodeRequest $request) {
        $domain = $request->input('domain');
        $accessCode = $request->input('accessCode');

        try {
            return Connect::setup($domain, $accessCode) ? 'true' : 'false';
        }
        catch (ProcessFailedException $ex) {
            abort(500, $ex->getMessage());
        }
    }

    /**
     * Status of DynDNS for given 1&1 domain.
     * 
     * @param \App\Http\Requests\DynDnsBaseRequest  $request
     * 
     * @return string status text
     */
    public function status(DynDnsBaseRequest $request) {
        $domain = $request->input('domain');

        try {
            return Connect::status($domain);
        }
        catch (ProcessFailedException $ex) {
            abort(500, $ex->getMessage());
        }
    }

    /**
     * Update public ip of DynDNS for given 1&1 domain.
     * 
     * @param \App\Http\Requests\DynDnsBaseRequest  $request
     * 
     * @return string update message
     */
    public function update(DynDnsBaseRequest $request) {
        $domain = $request->input('domain');
        $ip = $request->ip();
        abort_unless(filter_var($ip, FILTER_VALIDATE_IP), 400, "Unsupported client ip: '$ip'");
        if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            // private client ip => same network
            // -> use public ip of current network
            $ip = file_get_contents("https://api.ipify.org");
        }
    
        try {
            return Connect::update($domain, $ip);
        }
        catch (ProcessFailedException $ex) {
            abort(500, $ex->getMessage());
        }
    }
}

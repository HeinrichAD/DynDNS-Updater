<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DynDnsRedirectRequest extends DynDnsBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return parent::rules() + [
            'redirect' => 'boolean|nullable',
        ];
    }
}

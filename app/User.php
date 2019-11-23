<?php

namespace App;

use App\Notifications\ApiTokenUpdateNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    /**
     * Get settings file path.
     * 
     * @return string file path
     */
    public function settingsPath() {
        return "domains/settings-{$this->id}.txt";
    }

    /**
     * Get settings file content.
     * 
     * @param bool $assoc  When true, returned objects will be converted into associative arrays.
     * 
     * @param object|array
     */
    public function domains(bool $assoc = false) {
        $json = Storage::disk('local')->get($this->settingsPath());
        return json_decode($json, $assoc);
    }

    /**
     * Update API token.
     * 
     * @param bool $notify  notify user over API token update
     * 
     * @return string new API token
     */
    public function updateApiToken(bool $notify = true) {
        $token = Str::random(30);

        $this->forceFill([
            'api_token' => hash('sha256', $token),
        ])->save();

        if ($notify) {
            $this->notify(new ApiTokenUpdateNotification($token));
        }

        return $token;
    }
}

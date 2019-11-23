<?php

namespace App\DynDNS;

use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class Connect
{
    /**
     * Get config file path.
     * 
     * @return string full file path
     */
    protected static function getConfigFilePath() {
        return storage_path('app/' . auth()->user()->settingsPath());
    }

    /**
     * Get activation url for given 1&1 domain.
     * 
     * @param string $domain      domain name  e.g. example.com
     * 
     * @return string activation url
     */
    public static function getActivationUrl(string $domain) {
        return "https://domainconnect.1and1.com/async/v2/domainTemplates/providers/domainconnect.org?client_id=domainconnect.org&scope=dynamicdns&domain=${domain}&host=&IP=0.0.0.0&redirect_uri=https%3A%2F%2Fdynamicdns.domainconnect.org%2Fddnscode";
    }

    /**
     * Setup DynDNS for given 1&1 domain.
     * 
     * @param string $domain      domain name  e.g. example.com
     * @param string $accessCode  1&1 access code
     * 
     * @return bool success state
     * 
     * @throws \Symfony\Component\Process\Exception\ProcessFailedException
     */
    public static function setup(string $domain, string $accessCode) {
        $filesystem = new Filesystem();
        $path = static::getConfigFilePath();
        if (!$filesystem->exists($dir = $filesystem->dirname($path))) {
            $filesystem->makeDirectory($dir);
        }

        $process = new Process([
            'domain-connect-dyndns',
            'setup',
            '--config',
            $path,
            '--domain',
            $domain,
            '--access-code',
            $accessCode,
            '--prevent-browser-auto-open',
        ]);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            $error = new ProcessFailedException($process);
            logger()->error($error->getMessage());
            throw $error;
        }

        return true;
    }

    /**
     * Status of DynDNS for given 1&1 domain.
     * 
     * @param string $domain      domain name  e.g. example.com
     * 
     * @return string status text
     * 
     * @throws \Symfony\Component\Process\Exception\ProcessFailedException
     */
    public static function status(string $domain) {
        $process = new Process([
            'domain-connect-dyndns',
            'status',
            '--config',
            static::getConfigFilePath(),
            '--domain',
            $domain,
        ]);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            $error = new ProcessFailedException($process);
            logger()->error($error->getMessage());
            throw $error;
        }

        return $process->getOutput();
    }

    /**
     * Update public ip of DynDNS for given 1&1 domain.
     * 
     * @param string $domain      domain name  e.g. example.com
     * @param string $ip          new public ip
     * 
     * @return string update message
     * 
     * @throws \Symfony\Component\Process\Exception\ProcessFailedException
     */
    public static function update(string $domain, string $ip) {
        $process = new Process([
            'domain-connect-dyndns',
            'update',
            '--config',
            static::getConfigFilePath(),
            '--domain',
            $domain,
            '--force-public-ip',
            $ip,
        ]);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            $error = new ProcessFailedException($process);
            logger()->error($error->getMessage());
            throw $error;
        }

        return $process->getOutput();
    }
}

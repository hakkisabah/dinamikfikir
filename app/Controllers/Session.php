<?php


namespace App\Controllers;


class Session implements Sessions
{

    /**
     * @param string $key
     * @param $payload
     * @return mixed
     */
    public function setSession(string $key, $payload)
    {
        if ($key == 'userInfo') {
            $payload['isLoggedIn'] = true;
        }
        session()->set($key, $payload);
    }

    /**
     * @param string $keyName
     * @return mixed
     */
    public function getSession(string $keyName)
    {
        return session()->get($keyName);
    }

    /**
     * @param string|null $key
     * @return mixed
     */
    public function removeSession(string $key = null)
    {
        if ($key == null) {
            session()->stop();
            session()->destroy();
        }else{
            session()->remove($key);
        }
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function isSession(string $key)
    {
        return session()->has($key);
    }

    public function setTempSession($key,$expireTime = 30)
    {
        session()->markAsTempdata($key, $expireTime);
    }

    public function getTempSession($key)
    {
        return session()->getTempdata($key);
    }
}
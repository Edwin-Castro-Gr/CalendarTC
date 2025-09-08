<?php

namespace App\Libraries;

use App\Models\User;
class CIAuth
{
        public static function setCIAuth($result): bool
    {
        $session = session();
        $array = [
            'logged_in' => true
        ];
        $userdata = $result;
        $session->set('userdata', $userdata);
        $session->set($array);
        return true;
    }

    public static function id(): bool|null
    {
        $session = session();
        if ($session->has('logged_in')) {
            if ($session->has('userdata')) {
                return $session->get('userdata')['id'];
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    public static function check(): bool
    {
        $session = session();

        return $session->has('logged_in');
    }

    public static function forget(): bool|null
    {
        $session = session();
        $session->remove('logged_in');
        $session->remove('userdata');
        return true;
    }
    public static function user(): array|object|null
    {
        $session = session();
        if ($session->has('logged_in')) {
            if ($session->has('userdata')) {
                // return $session->get('userdata');
                $user = new User();
                return $user->asObject()->where('id', CIAuth::id())->first();
            } else {
                return null;
            }
        } else {
            return null;
        }
    }
    /**
     * Log out the user.
     */
    public static function logout(): void
    {
        session()->destroy();
    }
}
<?php

namespace App\Libraries;

class Hash
{
    /**
     * Hash a password using the Bcrypt algorithm.
     * @param string $password The password to hash.
     * @return string The hashed password.
     */
    public static function make(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Verify a password against a hash.
     *
     * @param string $password The password to verify.
     * @param string $db_hashed_password The hash to verify against.
     * @return bool True if the password matches the hash, false otherwise.
     */
    public static function check(string $password, string $db_hashed_password)
    {
        return password_verify($password, $db_hashed_password);           
    }
}
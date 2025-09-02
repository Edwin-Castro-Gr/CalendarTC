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
     * Verifica una contraseña frente a un hash.
     * Devuelve false en cualquier caso inválido y registra el error para depuración.
     */
    public static function check(string $password, string $db_hashed_password)
    {
        // Validaciones básicas
        if ($password === '' || $db_hashed_password === '' || !is_string($db_hashed_password)) {
            log_message('debug', 'Hash::check - parámetros inválidos. password empty? ' . ($password === '' ? 'sí' : 'no') . '; hash empty? ' . ($db_hashed_password === '' ? 'sí' : 'no') . '; type: ' . gettype($db_hashed_password));
            return false;
        }

        try {
            $result = password_verify($password, $db_hashed_password);
            log_message('debug', 'Hash::check - password_verify resultado: ' . ($result ? 'true' : 'false') . '; hash_len=' . strlen($db_hashed_password));
            return $result;
        } catch (\Throwable $e) {
            log_message('error', 'Hash::check - excepción: ' . $e->getMessage());
            return false;
        }
    }

    public static function needsRehash(string $hash): bool
    {
        return password_needs_rehash($hash, PASSWORD_DEFAULT);
    }
}
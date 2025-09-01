<?php

namespace App\Validation;

class IsPasswordStrong
{
    public function IsPasswordStrong(string $password): bool
    {
        // Verificar longitud mínima
        if (strlen($password) < 8) {
            return false;
        }

        // Verificar al menos una letra mayúscula
        if (!preg_match('/^(?=.*[\W_])(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{5,20}$/', $password)) {
            return false;
        }

        return true;
    }
}

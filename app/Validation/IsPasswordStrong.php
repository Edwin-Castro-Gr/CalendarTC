<?php

namespace App\Validation;

class IsPasswordStrong
{
    /**
     * Permite invocar la clase como función: new IsPasswordStrong()(...)
     */
    public function __invoke(string $password, ?string $additional = null): bool
    {
        return $this->isPasswordStrong($password);
    }

    /**
     * Método principal con lógica de validación.
     */
    public function isPasswordStrong(string $password): bool
    {
        // Longitud mínima
        if (strlen($password) < 6) {
            return false;
        }

        // Al menos una mayúscula, una minúscula, un dígito y un carácter especial
        if (!preg_match('/(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{6,}/', $password)) {
            return false;
        }

        return true;
    }

    /**
     * Proveer firma 'validate' por compatibilidad con algunos usos de CI4.
     */
    public function validate(string $str, string $fields = null, array $data = []): bool
    {
        return $this->isPasswordStrong($str);
    }
}

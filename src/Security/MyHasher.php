<?php

namespace App\Security;

use Symfony\Component\PasswordHasher\PasswordHasherInterface;

final class MyHasher implements PasswordHasherInterface
{
    public function hash(string $plainPassword): string
    {
        return str_rot13($plainPassword);
    }

    public function verify(string $hashedPassword, string $plainPassword): bool
    {
        return $this->hash($plainPassword) === $hashedPassword;
    }

    public function needsRehash(string $hashedPassword): bool
    {
        return false;
    }
}

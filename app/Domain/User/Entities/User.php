<?php

namespace App\Domain\User\Entities;

use Illuminate\Support\Str;

class User
{
    private function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $email,
    ) {
    }

    static function create(
        string $name,
        string $email,
    ) {
        $id = Str::random(20);

        return new User($id, $name, $email);
    }

    static function reconstruct(
        string $id,
        string $name,
        string $email,
    ) {
        return new User($id, $name, $email);
    }
}

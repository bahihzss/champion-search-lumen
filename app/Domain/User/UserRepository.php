<?php

namespace App\Domain\User;

use App\Domain\User\Entities\User;

interface UserRepository
{
    public function save(User $user);

    public function findById(string $id): User|null;
}

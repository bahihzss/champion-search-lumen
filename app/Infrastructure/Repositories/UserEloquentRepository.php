<?php

namespace App\Infrastructure\Repositories;

use App\Domain\User\Entities\User;
use App\Domain\User\UserRepository;
use App\Infrastructure\Models\UserModel;

class UserEloquentRepository implements UserRepository
{
    public function save(User $user)
    {
        UserModel::query()->insert((array) $user);
    }

    public function findById(string $id): User|null
    {
        $userData = UserModel::query()->find($id);

        return $userData ? User::reconstruct(
            id: $userData->id,
            name: $userData->name,
            email: $userData->email,
        ) : null;
    }
}

<?php

namespace Tests\Domain\Entities;

use App\Domain\User\Entities\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * @test
     * @noinspection NonAsciiCharacters
     */
    public function createにnameとemailを渡すとidが生成されたUserが返ってくる()
    {
        $user = User::create(name: 'Tanaka', email: 'tanaka@example.com');

        $this->assertMatchesRegularExpression("/^[a-zA-Z0-9]{20}$/", $user->id);
        $this->assertEquals($user->name, 'Tanaka');
        $this->assertEquals($user->email, 'tanaka@example.com');
    }
}

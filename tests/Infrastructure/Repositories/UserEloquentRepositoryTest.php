<?php

namespace Tests\Infrastructure\Repositories;

use App\Domain\User\Entities\User;
use App\Domain\User\UserRepository;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserEloquentRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    private UserRepository $repository;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->app->make(UserRepository::class);
    }

    /**
     * @test
     * @noinspection NonAsciiCharacters
     */
    public function saveで保存したものがfindByIdで取得できる()
    {
        $createdUser = User::create(name: 'Tanaka', email: 'tanaka@example.com');

        $this->repository->save($createdUser);
        $foundUser = $this->repository->findById($createdUser->id);

        $this->assertEquals($createdUser->id, $foundUser->id);
        $this->assertEquals($createdUser->name, $foundUser->name);
        $this->assertEquals($createdUser->email, $foundUser->email);
    }

    /**
     * @test
     * @noinspection NonAsciiCharacters
     */
    public function 存在しないidをfindByIdに渡すとnullが返ってくる()
    {
        $this->assertNull(
            $this->repository->findById('not-exist')
        );
    }
}

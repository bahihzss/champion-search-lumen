<?php

namespace Tests\E2E\User;

use App\Domain\User\Entities\User;
use App\Infrastructure\Models\UserModel;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserFindByIdControllerTest extends TestCase
{
    use DatabaseMigrations;

    private User $existsUser;

    public function setUp(): void
    {
        parent::setUp();

        $user = UserModel::factory()->create();
        $this->existsUser = User::reconstruct(
            id: $user->id,
            name: $user->name,
            email: $user->email
        );
    }

    /**
     * api/v1/user/:id (GET)
     *
     * @test
     * @noinspection NonAsciiCharacters
     */
    public function api_v1_user_idへのGET()
    {
        $response = $this
            ->call('GET', '/api/v1/user/'.$this->existsUser->id);

        $statusCode = $response->status();
        $content = json_decode($response->getContent(), true);
        $this->assertEquals(200, $statusCode);
        $this->assertEquals(200, $content['statusCode']);

        $item = $content['item'];
        $this->assertEquals($this->existsUser->id, $item['id']);
        $this->assertEquals($this->existsUser->name, $item['name']);
        $this->assertEquals($this->existsUser->email, $item['email']);
    }

    /**
     * api/v1/user/:id (GET) NotFound
     *
     * @test
     * @noinspection NonAsciiCharacters
     */
    public function api_v1_userへのGET_NotFound()
    {
        $this
            ->get('/api/v1/user/not-exist')
            ->assertResponseStatus(404);
    }
}

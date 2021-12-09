<?php

namespace Tests\E2E\User;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserRegisterControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * api/v1/user (POST)
     *
     * @test
     * @noinspection NonAsciiCharacters
     */
    public function api_v1_userへのPOST()
    {
        $postData = [
            'name' => 'Tanaka',
            'email' => 'tanaka@example.com',
        ];

        $response = $this
            ->call('POST', '/api/v1/user', $postData);

        $statusCode = $response->status();
        $content = json_decode($response->getContent(), true);
        $this->assertEquals(201, $statusCode);
        $this->assertEquals(201, $content['statusCode']);

        $item = $content['item'];
        $this->assertEquals($postData['name'], $item['name']);
        $this->assertEquals($postData['email'], $item['email']);
        $this->assertMatchesRegularExpression("/^[a-zA-Z0-9]{20}$/", $item['id']);
    }

    /**
     * api/v1/user (POST) バリデーション
     *
     * @test
     * @noinspection NonAsciiCharacters
     */
    public function api_v1_userへのPOST_バリデーション()
    {
        $invalidPostData = [
            'name' => 'Tanaka',
            'email' => '',
        ];

        $this
            ->json('POST', '/api/v1/user', $invalidPostData)
            ->assertResponseStatus(422);
    }
}

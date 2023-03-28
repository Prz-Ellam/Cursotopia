<?php

namespace Tests\Controllers;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class UserControllerTest extends TestCase {
    private $client;

    public function setUp(): void {
        $this->client = new Client([
            'base_uri' => 'http://localhost:80/',
            'cookies' => true,
            'http_errors' => false,
        ]);
    }

    public function testGetUsersReturns200() {
        $response = $this->client->get('/home');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testUpdateUser() {
        $data = [
            "name" => "Eliam",
            "lastName" => "Rodríguez Pérez",
            "birthDate" => "2022-10-26",
            "gender" => "Femenino",
            "email" => "elisa@correo.com"
        ];

        $response = $this->client->post('/api/v1/auth', [
            'json' => [
                "email" => "elisa@correo.com",
                "password" => "123Abe!!"
            ]
        ]);

        $response = $this->client->patch('/api/v1/users/3', [
            'json' => $data
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        //$this->assertDatabaseHas('users', $data);
    }
}

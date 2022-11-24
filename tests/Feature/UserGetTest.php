<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class UserGetTest extends TestCase
{
    /**
     * Create Authenticated User for Test.
     *
     * @return token
     */
    protected function authenticate()
    {
        $user = auth()->user();

        if(!isset($user))
        {
            $user = User::create([
                "username" => "UnitTesting".substr(md5(mt_rand()), 0, 4),
                "first_name" => "Unit",
                "last_name" => "Test",
                "role" => 1,
                "password" => bcrypt('testing')
            ]);
        }

        if(!auth()->attempt(['username' => $user->username, 'password' => 'testing']))
        {
            return response(["message" => "Login credentials are invalid"]);
        }

        return $accessToken = auth()->user()->createToken('authToken')->accessToken;
    }

    /**
     * Test Get a User
     *
     */
    public function test_get_user()
    {
        $token = $this->authenticate();

        $response = $this->withHeaders([
            "Authorization" => 'Bearer '.$token,
            "Accept" => "application/json",
            "Content-Type" => "application/json"
        ])->json('GET', 'api/users/'.auth()->user()->id);

        Log::info(1, [$response->getContent()]);

        // Delete Test User Data
        User::where('username', 'UnitTesting4')->delete();

        $response->assertStatus(200);
    }
}

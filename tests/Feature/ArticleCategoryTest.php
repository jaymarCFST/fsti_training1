<?php

namespace Tests\Feature;

use App\Models\ArticleCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class ArticleCategoryTest extends TestCase
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
     * Get All Article Categories Test
     *
     */
    public function test_get_all_article_categories()
    {
        $token = $this->authenticate();

        $response = $this->withHeaders([
            "Authorization" => 'Bearer '.$token,
            "Accept" => "application/json",
            "Content-Type" => "application/json"
        ])->json('GET', 'api/article-categories/all');

        Log::info(1, [$response->getContent()]);

        // Delete Test User Data
        User::where('username', 'LIKE', '%UnitTesting%')->delete();

        $response->assertStatus(200);
    }

    /**
     * Create new Article Category Test
     *
     */
    public function test_create_article_category()
    {
        $token = $this->authenticate();

        $response = $this->withHeaders([
            "Authorization" => 'Bearer '.$token,
            "Accept" => "application/json",
            "Content-Type" => "application/json"
        ])->json('POST', 'api/article-categories/store', [
            "name" => "test"
        ]);

        Log::info(1, [$response->getContent()]);

        // Delete Test User Data
        User::where('username', 'LIKE', '%UnitTesting%')->delete();

        $response->assertStatus(200);
    }

    /**
     * Get Article Category Test
     *
     */
    public function test_get_article_category()
    {
        $token = $this->authenticate();

        $category = ArticleCategory::latest('created_at')->first();

        $response = $this->withHeaders([
            "Authorization" => 'Bearer '.$token,
            "Accept" => "application/json",
            "Content-Type" => "application/json"
        ])->json('GET', 'api/article-categories/'.$category->id);

        Log::info(1, [$response->getContent()]);

        // Delete Test User Data
        User::where('username', 'LIKE', '%UnitTesting%')->delete();

        $response->assertStatus(200);
    }

    /**
     * Update Article Category Test
     *
     */
    public function test_update_article_category()
    {
        $token = $this->authenticate();

        $category = ArticleCategory::latest('created_at')->first();

        $response = $this->withHeaders([
            "Authorization" => 'Bearer '.$token,
            "Accept" => "application/json",
            "Content-Type" => "application/json"
        ])->json('PUT', 'api/article-categories/update', [
            "id" => $category->id,
            "name" => "test update"
        ]);

        Log::info(1, [$response->getContent()]);

        // Delete Test User Data
        User::where('username', 'LIKE', '%UnitTesting%')->delete();

        $response->assertStatus(200);
    }

    /**
     * Delete Article Category Test
     *
     */
    public function test_delete_article_category()
    {
        $token = $this->authenticate();

        $category = ArticleCategory::latest('created_at')->first();

        $response = $this->withHeaders([
            "Authorization" => 'Bearer '.$token,
            "Accept" => "application/json",
            "Content-Type" => "application/json"
        ])->json('DELETE', 'api/article-categories/'.$category->id);

        Log::info(1, [$response->getContent()]);

        // Delete Test User Data
        User::where('username', 'LIKE', '%UnitTesting%')->delete();

        $response->assertStatus(200);
    }
}

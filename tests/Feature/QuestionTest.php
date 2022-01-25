<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class BookTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/api/login');

        $response->assertStatus(200);
    }

    public function test_only_authenticated_user_can_add_question()
    {
        $email = "test".rand()."@hotmail.com";
        $user = \App\Models\User::create([
            'name' => 'Test',
            'email' => $email, 
            // note you need to use the bcrypt function here to hash your password
            'password' => bcrypt('123456')
        ]);
        // $user = User::factory()->create();      
        // Passport::actingAs($user);

        $response = $this->json('POST', '/api/questions', [
                'title' => 'new question post'.rand(),
                'body' => 'new question body posted',
                'user_id' => $user->id,
            ]);

        $response->assertStatus(200);
    }

}

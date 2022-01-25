<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Factory;
use Laravel\Passport\Passport;

class UserTest extends TestCase
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

    function redirect_to_home_page_and_logged_in_after_login()
    {                

        $user = factory(User::class)->create([
            'name' => 'Test',
            'email' => 'test@hotmail.com', 
            // note you need to use the bcrypt function here to hash your password
            'password' => bcrypt('123456')
        ]);      

        $response = $this->post('login', [
            'name' => 'Test',
            'email' => 'test@hotmail.com',
            'password' => '123456'          
        ]);

        //this works
        $response->assertRedirect('/');

        //this fails 
        $this->assertTrue(Auth::check());
    }
}

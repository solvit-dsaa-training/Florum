<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Factory;


class DeleteQuestionTest extends TestCase
{
    /**
     * test question delete function
     *
     * @return void
     */
    /** @test */
    public function user_can_destroy()
{
    $question = Question::factory()->create([
        'title' => 'What is unit test',
        'body'=> 'PHP unit is used for testing',
        'user_id' => User::find(1)->id,
    ]);

    // $user = factory(User::class)->create([
        //     'name' => 'Test',
        //     'email' => 'test@hotmail.com', 
        //     // note you need to use the bcrypt function here to hash your password
        //     'password' => bcrypt('123456')
        // ]); 

    $response = $this->delete('/api/questions/' . $question->id);

    $response->assertStatus(200);

    // $response->assertViewIs('category.index');
}
}

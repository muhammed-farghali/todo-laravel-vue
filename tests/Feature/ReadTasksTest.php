<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReadTasksTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function authenticated_user_can_get_its_tasks ()
    {
        $this->signIn();
        $tasks = $this->user->tasks;
        $this->getJson( 'api/tasks' )
             ->assertStatus( 200 )
             ->assertJson( [
                 'code'    => 2000,
                 'message' => 'get data successfully.',
                 'data'    => $tasks
             ] );
    }
}

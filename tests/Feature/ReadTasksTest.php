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
    public function authenticated_user_can_access_all_tasks ()
    {
        $this->signIn();
        $tasks = factory( 'App\Task', 10 )->raw();
        $this->user->tasks()->createMany( $tasks );
        $this->getJson( '/api/tasks' )
             ->assertStatus( 200 )
             ->assertJson( [
                 'success' => true,
                 'code'    => 's2000',
                 'message' => 'Data gotten successfully',
                 'data'    => $tasks
             ] );
    }

    /**
     * @test
     */
    public function guest_cannot_access_tasks ()
    {
        $this->getJson( '/api/tasks' )
             ->assertStatus( 401 )
             ->assertJson( [
                 'success' => false,
                 'code'    => 'e4004',
                 'message' => 'Unauthenticated User'
             ] );
    }
}

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
                 'code'    => GET_SUCCESS,
                 'message' => 'your tasks returned successfully.',
             ] );
    }

    /**
     * @test
     */
    public function authenticated_user_has_no_tasks ()
    {
        $this->signIn();
        $this->getJson( '/api/tasks' )
             ->assertStatus( 200 )
             ->assertJson( [
                 'success' => true,
                 'code'    => GET_SUCCESS,
                 'message' => 'you have no tasks.',
                 'data'    => []
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
                 'code'    => AUTHENTICATED_FAILED,
                 'message' => 'unauthenticated user.',
             ] );
    }
}

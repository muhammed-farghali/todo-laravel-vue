<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReadSingleTaskTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function authenticated_user_can_access_single_task_of_his_tasks ()
    {
        $this->signIn();
        $task = factory( 'App\Task' )->raw();
        $this->user->tasks()->create( $task );

        $user2 = create( 'App\User' );
        $user2->tasks()->create( factory( 'App\Task' )->raw() );


        $this->getJson( '/api/tasks/1' )
             ->assertStatus( 200 )
             ->assertJson( [
                 'success' => true,
                 'code'    => GET_SUCCESS,
                 'message' => 'your task returned successfully.',
                 'data'    => $task
             ] );

        $this->getJson( '/api/tasks/2' )
             ->assertStatus( 401 )
             ->assertJson( [
                 'success' => false,
                 'code'    => AUTHORIZED_FAILED,
                 'message' => 'unauthorized user.',
             ] );
    }

    /**
     * @test
     */
    public function guest_cannot_access_single_task ()
    {
        $user = create( 'App\User' );
        $user->tasks()->create( factory( 'App\Task' )->raw() );
        $this->getJson( '/api/tasks/1' )
             ->assertStatus( 401 )
             ->assertJson( [
                 'success' => false,
                 'code'    => AUTHENTICATED_FAILED,
                 'message' => 'unauthenticated user.'
             ] );
    }

    /**
     * @test
     */
    public function authenticated_user_cannot_access_not_exist_task ()
    {
        $this->signIn();
        $this->user->tasks()->create( factory( 'App\Task' )->raw() );
        $this->getJson( '/api/tasks/asd' )
             ->assertStatus( 404 )
             ->assertJson( [
                 'success' => false,
                 'code'    => 'e4000',
                 'message' => 'resource not found.'
             ] );
    }
}

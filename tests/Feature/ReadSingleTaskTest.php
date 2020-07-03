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
                 'code'    => 's2000',
                 'message' => 'Data gotten successfully',
                 'data'    => $task
             ] );

        $this->getJson( '/api/tasks/2' )
             ->assertStatus( 401 )
             ->assertJson( [
                 'success' => false,
                 'code'    => 'e4005',
                 'message' => 'Unauthorized User',
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
                 'code'    => 'e4004',
                 'message' => 'Unauthenticated User'
             ] );
    }
}

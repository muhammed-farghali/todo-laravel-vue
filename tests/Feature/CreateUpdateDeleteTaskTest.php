<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateUpdateDeleteTaskTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function authenticated_user_may_create_task ()
    {
        $this->signIn();
        $task = factory( 'App\Task' )->raw();
        $this->postJson( '/api/tasks', $task )
             ->assertStatus( 201 )->assertJson( [
                'success' => true,
                'code'    => 's2001',
                'message' => 'insert data successfully.',
                'data'    => $task
            ] );
    }

    /**
     * @test
     */
    public function guest_cannot_create_task ()
    {
        $task = factory( 'App\Task' )->raw();
        $this->postJson( '/api/tasks', $task )
             ->assertStatus( 401 )->assertJson( [
                'success' => false,
                'code'    => 'e4000',
                'message' => 'unauthenticated user.'
            ] );
    }

    /**
     * @test
     */
    public function authenticated_user_may_update_task ()
    {
        $this->signIn();
        $task = factory( 'App\Task' )->raw();
        $updateTask = $task;
        $updateTask['name'] = 'update task';

        $task = $this->user->tasks()->create( $task );

        $this->putJson( $task->path(), $updateTask )
             ->assertStatus( 200 )->assertJson( [
                'success' => true,
                'code'    => 's2002',
                'message' => 'update data successfully.',
                'data'    => $updateTask
            ] );

    }

    /**
     * @test
     */
    public function guest_cannot_update_task ()
    {
        $task = create( 'App\Task' );
        $this->putJson( $task->path(), [ 'name' => 'update task' ] )
             ->assertStatus( 401 )->assertJson( [
                'success' => false,
                'code'    => 'e4000',
                'message' => 'unauthenticated user.'
            ] );
    }

    /**
     * @test
     */
    public function authenticated_user_may_delete_task ()
    {
        $this->signIn();
        $task = factory( 'App\Task' )->raw();
        $task = $this->user->tasks()->create( $task );
        $this->deleteJson( $task->path() )
             ->assertStatus( 200 )
             ->assertJson( [
                 'success' => true,
                 'code'    => 's2003',
                 'message' => 'delete data successfully.'
             ] );
    }

    /**
     * @test
     */
    public function guest_cannot_delete_task ()
    {
        $task = factory( 'App\Task' )->create();
        $this->deleteJson( $task->path() )
             ->assertStatus( 401 )
             ->assertJson( [
                 'success' => false,
                 'code'    => 'e4000',
                 'message' => 'unauthenticated user.'
             ] );
    }
}

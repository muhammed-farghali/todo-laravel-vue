<?php

namespace App\Http\Controllers;

use App\Http\Resources\Task as TaskResource;
use App\Http\Resources\TaskCollection;
use App\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct ()
    {
        $this->middleware( 'auth:api' );
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index ()
    {
        $tasks = auth()->user()->tasks;
        $hasTasks = $tasks->isEmpty() ? false : true;
        if ( $hasTasks ) {
            $data = new TaskCollection( $tasks );
            $message = "your tasks returned successfully.";
        } else {
            $data = [];
            $message = "you have no tasks.";
        }
        return $this->successResponse( $data, GET_SUCCESS, $message, 200 );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store ( Request $request )
    {
        $task = auth()->user()->tasks()->create( $request->all() );
        return $this->successResponse( new TaskResource( $task ),
            POST_SUCCESS,
            'your task added successfully.',
            201 );
    }

    /**
     * Display the specified resource.
     *
     * @param Task $task
     * @return JsonResponse
     */
    public function show ( Task $task )
    {
        if ( $task === null ) {
            return $this->errorResponse( GET_FAILED, 'task not found.', 404 );
        }

        if ( (int)$task->user_id !== (int)auth()->user()->id ) {
            return $this->errorResponse( AUTHORIZED_FAILED, 'unauthorized user.', 401 );
        }

        return $this->successResponse( new TaskResource( $task ),
            GET_SUCCESS,
            'your task returned successfully.',
            200 );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Task    $task
     * @return JsonResponse
     */
    public function update ( Request $request, Task $task )
    {
        $task->update( $request->all() );
        return $this->successResponse( new TaskResource( $task ),
            UPDATE_SUCCESS,
            'your task updated successfully.',
            200 );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Task $task
     * @return JsonResponse
     */
    public function destroy ( Task $task )
    {
        $task->delete();
        return $this->successResponse( null,
            DELETE_SUCCESS,
            'your task deleted successfully.',
            200 );
    }
}

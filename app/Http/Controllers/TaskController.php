<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    public function __construct ()
    {
        $this->middleware( 'auth' );
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index ()
    {
        $tasks = auth()->user()->tasks;
        $hasTasks = $tasks->isEmpty() ? false : true;

        $res = [
            'success' => $hasTasks ? true : false,
            'code'    => $hasTasks ? 's2000' : 'e2000',
            'message' => $hasTasks ? 'Data gotten successfully' : 'Get data failed',
        ];
        $hasTasks ? $res['data'] = $tasks : null;
        return response( $res, 200 );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store ( Request $request )
    {
        $task = auth()->user()->tasks()->create( $request->all() );
        return response( [
            'success' => true,
            'code'    => 's2001',
            'message' => 'Data inserted successfully',
            'data'    => $task
        ], 201 );
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show ( int $id )
    {
        $task = Task::find( $id );

        if ( $task === null ) {
            return response( [
                'success' => false,
                'code'    => 'e2000',
                'message' => 'Get data failed'
            ], 404 );
        }

        if ( (int)$task->user_id !== (int)auth()->user()->id ) {
            $res = [
                'success' => false,
                'code'    => 'e4005',
                'message' => 'Unauthorized User'
            ];
            return response( $res, 401 );
        }
        $res = [
            'success' => true,
            'code'    => 's2000',
            'message' => 'Data gotten successfully',
            'data'    => $task
        ];
        return response( $res, 200 );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Task    $task
     * @return Response
     */
    public function update ( Request $request, Task $task )
    {
        $task->update( $request->all() );
        return response( [
            'success' => true,
            'code'    => 's2002',
            'message' => 'Data updated successfully',
            'data'    => $task
        ], 200 );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy ( int $id )
    {
        $task = Task::find( $id );
        if ( $task === null ) {
            return response( [
                'success' => false,
                'code'    => 'e2003',
                'message' => 'Delete data failed'
            ], 404 );
        }
        $task->delete();
        return response( [
            'success' => true,
            'code'    => 's2003',
            'message' => 'Data deleted successfully'
        ], 200 );
    }
}

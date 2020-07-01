<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct ()
    {
        $this->middleware( 'auth' );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index ()
    {
        $tasks = auth()->user()->tasks;
        $hasTasks = $tasks->isEmpty() ? false : true;

        $res = [
            'success' => $hasTasks ? true : false,
            'code'    => $hasTasks ? 's2000' : 'e2000',
            'message' => $hasTasks ? 'get data successfully.' : 'failed to get data.',
        ];
        $hasTasks ? $res['data'] = $tasks : null;
        return response()->json( $res, 200 );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store ( Request $request )
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Task $task
     * @return \Illuminate\Http\Response
     */
    public function show ( Task $task )
    {
        if ( $task->user_id != auth()->user()->id ) {
            $res = [
                'success' => false,
                'code'    => 'e2000',
                'message' => 'unauthorized user.'
            ];
            return response()->json( $res, 401 );
        }
        $res = [
            'success' => true,
            'code'    => 's2000',
            'message' => 'get data successfully.',
            'data'    => $task
        ];
        return response()->json( $res, 200 );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Task                $task
     * @return \Illuminate\Http\Response
     */
    public function update ( Request $request, Task $task )
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Task $task
     * @return \Illuminate\Http\Response
     */
    public function destroy ( Task $task )
    {
        //
    }
}

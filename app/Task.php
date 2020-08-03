<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];
//    protected $fillable = ['name', 'task_day', 'start_at', 'end_at', 'description'];


    public function user ()
    {
        return $this->belongsTo( 'App\User' );
    }

    public function path ()
    {
        return '/api/tasks/' . $this->id;
    }

}

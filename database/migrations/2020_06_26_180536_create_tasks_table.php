<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up ()
    {
        Schema::create( 'tasks', function ( Blueprint $table ) {
            $table->id();
            $table->string( 'name' );
            $table->text( 'description' )->nullable();
            $table->tinyInteger( 'duration' )->nullable();
            $table->date( 'task_day' )->nullable();
            $table->time( 'start_at', 0 )->nullable();
            $table->time( 'end_at', 0 )->nullable();
            $table->unsignedBigInteger( 'user_id' );
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down ()
    {
        Schema::dropIfExists( 'tasks' );
    }
}
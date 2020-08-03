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
            $table->string( 'duration' );
            $table->date( 'task_day' )->default(date('Y-m-d'));
            $table->time( 'start_at', 0 );
            $table->time( 'end_at', 0 );
            $table->boolean('done')->default(false);
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

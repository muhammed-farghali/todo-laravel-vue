<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use App\User;
use Faker\Generator as Faker;

$factory->define( Task::class, function ( Faker $faker ) {
    $rand = rand( 0, 1 );
    $startTime = null;
    $endTime = null;
    $hours = rand( 1, 4 );

    if ( $rand ) {
        $timestamp = rand( strtotime( "Jan 01 2020" ), strtotime( "Dec 31 2021" ) );
        $startTime = date( "H:i:s", $timestamp );
        $endTime = date( "H:i:s", ( $timestamp + $hours * 60 * 60 ) );
    }

    return [
        'name'        => $faker->word,
        'description' => function () use ( $faker ) {
            return rand( 0, 1 ) ? rtrim( $faker->sentence( rand( 3, 5 ), '.' ) ) : null;
        },
        'duration'    => function () use ( $rand, $hours ) {
            if ( $rand ) {
                return $hours;
            }
            return rand( 0, 1 ) ? rand( 1, 5 ) : null;
        },
        'task_day'    => function () use ( $rand ) {
            if ( $rand ) {
                $timestamp = rand( strtotime( "Jan 01 2020" ), strtotime( "Dec 31 2021" ) );
                return date( "Y-m-d", $timestamp );
            }
            return null;
        },
        'start_at'    => $startTime,
        'end_at'      => $endTime,
        'user_id'     => User::pluck( 'id' )->isEmpty()
            ? factory( 'App\User' )->create()->id
            : User::pluck( 'id' )->random()
    ];
} );

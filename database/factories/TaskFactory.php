<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use App\User;
use Faker\Generator as Faker;

$factory->define( Task::class, function ( Faker $faker ) {
    $hours = rand( 1, 5 );
    $timestamp = rand( strtotime( "Aug 01 2020" ), strtotime( "Dec 31 2021" ) );
    $timestampAfterHours = $timestamp + $hours * 60 * 60;
    $startTime = date( "H:i", $timestamp );
    $endTime = date( "H:i", $timestampAfterHours );

    return [
        'name'        => $faker->sentence,
        'description' => function () use ( $faker ) {
            return rand( 0, 1 ) ? rtrim( $faker->sentence( rand( 5, 8 ), '.' ) ) : null;
        },
        'duration'    => function () use ( $timestamp, $timestampAfterHours ) {
            return date( "H:i", ( $timestampAfterHours - $timestamp ) );
        },
        'task_day'    => function () use ( $timestamp ) {
            return date( "Y-m-d", $timestamp );
        },
        'start_at'    => $startTime,
        'end_at'      => $endTime,
        'done'        => rand( 0, 1 ) ? true : false,
        'user_id'     => User::pluck( 'id' )->isEmpty()
            ? factory( 'App\User' )->create()->id
            : User::pluck( 'id' )->random()
    ];
} );

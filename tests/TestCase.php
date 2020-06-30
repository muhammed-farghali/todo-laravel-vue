<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @var User|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed|null
     */
    protected $user;

    protected function signIn ( User $user = null )
    {
        $user = ( $user instanceof User ) ? $user : create( 'App\User' );
        $this->user = $user;
        $this->actingAs( $user );
        return $this;
    }
}

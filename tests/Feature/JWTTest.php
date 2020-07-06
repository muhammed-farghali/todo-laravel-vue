<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function guest_may_register ()
    {
        $userData = $this->userData();
        $this->postJson( '/api/auth/register', $userData )
             ->assertStatus( 201 )
             ->assertJsonStructure( [ 'message', 'user' ] );

    }

    /**
     * @test
     */
    public function user_may_login ()
    {
        $userData = $this->userData();
        // Register the user
        $this->postJson( '/api/auth/register', $userData );

        // Test login
        $this->postJson( '/api/auth/login', [
            'email'    => $userData['email'],
            'password' => $userData['password']
        ] )
             ->assertStatus( 200 )
             ->assertJsonStructure( [ 'access_token', 'token_type', 'expires_in' ] );
    }

    /**
     * @test
     */
    public function user_may_logout ()
    {
        $this->signIn();
        $token = JWTAuth::fromUser( $this->user );
        $this->postJson( '/api/auth/logout', [], [ 'Authorization' => "Bearer $token" ] )
             ->assertStatus( 200 )
             ->assertJson( [
                 'message' => 'Successfully logged out'
             ] );
    }


    private function userData (): array
    {
        return [
            'name'                  => 'Test Developer',
            'email'                 => 'test@test.test',
            "password"              => "123456789",
            "password_confirmation" => "123456789"
        ];
    }
}

<?php

function create ( string $model, int $amount = 1, array $overrides = [] )
{
    if ( $amount === 1 ) {
        return factory( $model )->create( $overrides );
    }
    return factory( $model, $amount )->create( $overrides );
}

function make ( string $model, int $amount = 1, array $overrides = [] )
{
    if ( $amount === 1 ) {
        return factory( $model )->make( $overrides );
    }
    return factory( $model, $amount )->make( $overrides );
}

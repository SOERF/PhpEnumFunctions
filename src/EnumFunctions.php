<?php

namespace Streamedup\PhpEnumFunctions;

use Error;
use Illuminate\Support\Collection;
use Illuminate\Support\Enumerable;
use UnitEnum;

/**
 * @method static cases()
 */
trait EnumFunctions
{
    public function is ( mixed $enum ) : bool
    {
        if ( $enum instanceof static )
        {
            return $this === $enum;
        }
        return $this->serializedValue() === $enum;
    }

    public function isNot ( mixed $enum ) : bool
    {
        return !$this->is( $enum );
    }

    public function in ( array|Collection|Enumerable $enums ) : bool
    {
        foreach ( $enums as $enum )
        {
            if ( $this->is( $enum ) )
            {
                return true;
            }
        }
        return false;
    }

    public function notIn ( array|Collection|Enumerable $enums ) : bool
    {
        return !$this->in( $enums );
    }

    public static function fromKey ( string $key ) : static
    {
        return static::fromName( $key );
    }

    public static function fromName ( ?string $name ) : ?static
    {
        if ( $name === null )
        {
            return null;
        }
        return static::class::{$name};
    }

    public static function getInstances () : array
    {
        return static::cases();
    }

    public static function hasName ( string $name ) : bool
    {
        try
        {
            static::fromName( $name );
            return true;
        }
        catch ( Error $e )
        {
            return false;
        }
    }

    public static function getNames () : array
    {
        return collect( static::cases() )->map( fn( UnitEnum $c ) => $c->name )->all();
    }

    public static function count () : int
    {
        return count( static::cases() );
    }

    public function serializedValue () : string
    {
        return $this->name;
    }
}

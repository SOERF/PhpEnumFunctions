<?php

namespace Streamedup\PhpEnumFunctions;

use BackedEnum;

trait BackedEnumFunctions
{
    use EnumFunctions;

    public static function fromValue ( string|int $value ) : static
    {
        return static::from( $value );
    }

    public static function hasValue ( string|int $value ) : bool
    {
        return !!static::tryFrom( $value );
    }

    public static function getValues() : array
    {
        return collect(static::cases())->map(fn(BackedEnum $c)=>$c->value)->all();
    }

    public function serializedValue () : string|int
    {
        return $this->value;
    }
}

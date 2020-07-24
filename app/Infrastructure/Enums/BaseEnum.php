<?php
namespace App\Infrastructure;

use BenSampo\Enum\Enum as BaseEnum;
use BenSampo\Enum\Contracts\LocalizedEnum;

class Enum extends BaseEnum implements LocalizedEnum
{
    public static function getDescriptions(): array
    {
        $values = self::getValues();

        $descriptions = [];
        foreach ($values as $value) {
            $descriptions[$value] = self::getDescription($value);
        }

        return $descriptions;
    }
}

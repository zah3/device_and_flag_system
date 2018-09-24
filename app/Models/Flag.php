<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flag extends Model
{
    private const FLAG_NAME_UNPACKING = 'unpacking'; // rozpakowanie
    private const FLAG_NAME_TESTING_EFFICIENT = 'testing_efficient'; // testowanie_sprawny
    private const FLAG_NAME_TESTING_BROKEN = 'testing_broken'; // testowanie_uszkodzony
    private const FLAG_NAME_PACKING_BROKEN = 'packing_broken'; // pakowanie_uszkodzony
    private const FLAG_NAME_CLEANING = 'cleaning'; // czyszczenie
    private const FLAG_NAME_HOUSING_REPLACEMENT = 'housing_replacement'; // wymiana obudowy
    private const FLAG_NAME_PACKING = 'packing'; // pakowanie

    public const AVAILABLE_FLAG_NAMES = [
        self::FLAG_NAME_UNPACKING,
        self::FLAG_NAME_TESTING_EFFICIENT,
        self::FLAG_NAME_TESTING_BROKEN,
        self::FLAG_NAME_PACKING_BROKEN,
        self::FLAG_NAME_CLEANING,
        self::FLAG_NAME_HOUSING_REPLACEMENT,
        self::FLAG_NAME_PACKING
    ];
}

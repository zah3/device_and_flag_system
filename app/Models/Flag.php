<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Flag extends Model
{
    public const FLAG_NAME_UNPACKING = 'unpacking'; // rozpakowanie
    public const FLAG_NAME_TESTING_EFFICIENT = 'testing_efficient'; // testowanie_sprawny
    public const FLAG_NAME_TESTING_BROKEN = 'testing_broken'; // testowanie_uszkodzony
    public const FLAG_NAME_PACKING_BROKEN = 'packing_broken'; // pakowanie_uszkodzony
    public const FLAG_NAME_CLEANING = 'cleaning'; // czyszczenie
    public const FLAG_NAME_HOUSING_REPLACEMENT = 'housing_replacement'; // wymiana obudowy
    public const FLAG_NAME_PACKING = 'packing'; // pakowanie

    public const AVAILABLE_FLAG_NAMES = [
        self::FLAG_NAME_UNPACKING,
        self::FLAG_NAME_TESTING_EFFICIENT,
        self::FLAG_NAME_TESTING_BROKEN,
        self::FLAG_NAME_PACKING_BROKEN,
        self::FLAG_NAME_CLEANING,
        self::FLAG_NAME_HOUSING_REPLACEMENT,
        self::FLAG_NAME_PACKING
    ];
    protected $dates = [
        'created_at',
    ];
    protected $fillable = [
        'name',
        'from_ip_address',
    ];

    public function __construct(Request $request)
    {
        parent::__construct([]);
        $this->name = $request->flag_name;
        $this->from_ip_addres = $request->ip();
        $this->created_at = date("Y-m-d H:i:s");
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllowedCurrency extends Model
{
    use HasFactory;
    protected $guarded = ['currency_code'];

    protected $table = 'allowed_currencies';
    protected $primaryKey = 'currency_code';
    public $incrementing = false;
    protected $keyType = 'string';
}

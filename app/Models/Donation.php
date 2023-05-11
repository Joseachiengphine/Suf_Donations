<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;
    protected $guarded = ['donation_code'];

    protected $table = 'donations';
    protected $primaryKey = 'donation_code';
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;
}

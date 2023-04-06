<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    const REGISTRATION_AMOUNT = 'registration-amount';
    const CURRENT_MATCHING_DONOR='current-matching-donor';
    const MATCHING_PERCENTAGE='matching-percentage';
    const CHECKOUT_TYPE ='checkout-type';
}




















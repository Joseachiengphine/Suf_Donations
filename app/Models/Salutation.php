<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salutation extends Model
{
    use HasFactory;
    protected $guarded = ['title'];

    protected $table = 'salutations';
    protected $primaryKey = 'title';
    public $incrementing = false;
    protected $keyType = 'string';
}

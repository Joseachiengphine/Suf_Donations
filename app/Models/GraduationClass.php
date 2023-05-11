<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GraduationClass extends Model
{
    use HasFactory;
    protected $guarded = ['graduation_key'];

    protected $table = 'graduation_classes';
    protected $primaryKey = 'graduation_key';
    public $incrementing = false;
    protected $keyType = 'string';
}

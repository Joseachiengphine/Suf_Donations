<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipationOption extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'participation_options';
    protected $primaryKey = 'id';
}

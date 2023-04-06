<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relations extends Model
{
    use HasFactory;
    protected $guarded = ['relation_name'];
    protected $table = 'relations';
    protected $primaryKey = 'relation_name';
    public $incrementing = false;
    protected $keyType = 'string';
}

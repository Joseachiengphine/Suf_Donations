<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;
    protected $guarded = ['campaign_name'];

    protected $table = 'campaigns';
    protected $primaryKey = 'campaign_name';
    public $incrementing = false;
    protected $keyType = 'string';

    const VC_RUN = "Vice Chancellor's Run";
}

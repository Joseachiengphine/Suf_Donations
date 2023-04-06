<?php

namespace App\Models;

use App\Models\VcrunSupporter;
use App\Models\VcrunRegistration;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DonationRequest extends Model
{
    use HasFactory;
    protected $guarded = ['merchantID'];
    protected $table = 'donation_requests';
    protected $primaryKey = 'merchantID';
    public $incrementing = false;
    protected $keyType = 'string';

    //public $timestamps = false; // disable automatic timestamps

    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_update';

    public function vcrunRegistration(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(VcrunRegistration::class,'request_merchant_id','merchantID');
    }
    public function vcrunSupports(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(VcrunSupporter::class,'request_merchant_id','merchantID');
    }
}


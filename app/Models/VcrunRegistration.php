<?php

namespace App\Models;

use App\Models\VcrunSupporter;
use App\Models\DonationRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VcrunRegistration extends Model
{
    use HasFactory;
    public function getBalanceAttribute() {
        return $this->registration_amount - $this->paid_amount;
    }
    public function donationRequest(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(DonationRequest::class,'request_merchant_id','merchantID');
    }
    public function vcrunSupporters(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(VcrunSupporter::class,'supported_registrant_id');
    }
}

<?php

namespace App\Models;

use App\Models\VcrunSupporter;
use App\Models\DonationRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class VcrunRegistration extends Model
{
    use HasFactory;
    public function getBalanceAttribute() {
        return $this->registration_amount - $this->paid_amount;
    }
    public function donationRequest(): BelongsTo
    {
        return $this->belongsTo(DonationRequest::class,'request_merchant_id','merchantID');
    }

    public function vcrunSupporters(): HasMany
    {
        return $this->hasMany(VcrunSupporter::class,'supported_registrant_id');
    }

}

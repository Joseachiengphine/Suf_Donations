<?php

namespace App\Models;

use App\Models\DonationRequest;
use App\Models\VcrunRegistration;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VcrunSupporter extends Model
{
    use HasFactory;
    public function getBalanceAttribute() {
        return $this->support_amount - $this->paid_amount;
    }
    public function donationRequest(): BelongsTo
    {
        return $this->belongsTo(DonationRequest::class,'request_merchant_id','merchantID');
    }
    public function supportedRegistrant(): BelongsTo
    {
        return $this->belongsTo(VcrunRegistration::class, 'supported_registrant_id');
    }
}

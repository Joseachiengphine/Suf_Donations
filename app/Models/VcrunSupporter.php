<?php

namespace App\Models;

use App\Models\DonationRequest;
use App\Models\VcrunRegistration;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VcrunSupporter extends Model
{
    use HasFactory;
    public function getBalanceAttribute() {
        return $this->support_amount - $this->paid_amount;
    }
    public function donationRequest(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(DonationRequest::class,'request_merchant_id','merchantID');
    }
    public function supportedRegistrant(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(VcrunRegistration::class, 'supported_registrant_id');
    }
}

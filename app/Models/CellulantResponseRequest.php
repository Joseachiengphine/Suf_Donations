<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CellulantResponseRequest extends Model
{
    use HasFactory;

    protected $guarded = ['cellulantResponseID'];

    protected $table = 'cellulant_responses';
    protected $primaryKey = 'cellulantResponseID';
    public $incrementing = true;
    protected $keyType = 'string';
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_update';
    public function donationrequest(): BelongsTo
    {
        return $this->belongsTo(DonationRequest::class,'merchantTransactionID','merchantID');
    }
//    public function VcrunRegistration(): \Illuminate\Database\Eloquent\Relations\BelongsTo
//    {
//        return $this->belongsTo(VcrunRegistration::class,'request_merchant_id','merchantTransactionID');
//    }

}

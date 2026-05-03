<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shipment extends Model {
    protected $fillable = ['sourcing_request_id','tracking_number','carrier','origin','destination','method','status','estimated_arrival'];
    protected $casts = ['estimated_arrival' => 'date'];

    public function sourcingRequest(): BelongsTo { return $this->belongsTo(SourcingRequest::class); }
}

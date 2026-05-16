<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\LogsActivity;

class Quote extends Model {
    use LogsActivity;
    
    protected $fillable = ['sourcing_request_id','supplier_name','unit_price','total_price','currency','moq','lead_time','notes','status'];
    protected $casts = ['unit_price' => 'decimal:2', 'total_price' => 'decimal:2'];

    public function sourcingRequest(): BelongsTo { return $this->belongsTo(SourcingRequest::class); }
}

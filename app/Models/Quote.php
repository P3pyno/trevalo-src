<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Supplier;
use App\Traits\LogsActivity;

class Quote extends Model {
    use LogsActivity;
    
    protected $fillable = ['sourcing_request_id','supplier_id','supplier_name','quote_file_path','moq','lead_time','notes','status','payment_method'];

    public function sourcingRequest(): BelongsTo { return $this->belongsTo(SourcingRequest::class); }
    public function supplier(): BelongsTo { return $this->belongsTo(Supplier::class); }
}

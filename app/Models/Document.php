<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model {
    protected $fillable = ['sourcing_request_id','name','type','file_path','size'];

    public function sourcingRequest(): BelongsTo { return $this->belongsTo(SourcingRequest::class); }
}

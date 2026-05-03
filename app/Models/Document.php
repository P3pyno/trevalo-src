<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model {
    protected $fillable = ['user_id','sourcing_request_id','name','type','file_path','url','size'];

    public function sourcingRequest(): BelongsTo { return $this->belongsTo(SourcingRequest::class); }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
}

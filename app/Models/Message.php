<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model {
    protected $fillable = ['sourcing_request_id','user_id','is_from_team','body','attachment_path','attachment_name','attachment_mime'];
    protected $casts = ['is_from_team' => 'boolean'];

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function sourcingRequest(): BelongsTo { return $this->belongsTo(SourcingRequest::class); }
}

<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Message extends Model {
    protected $fillable = ['sourcing_request_id','user_id','is_from_team','body','attachment_path','attachment_name','attachment_mime'];
    protected $casts = ['is_from_team' => 'boolean'];

    public function getAttachmentPathAttribute($value): ?string {
        if (!is_string($value) || $value === '') {
            return null;
        }

        if (Str::startsWith($value, ['http://', 'https://'])) {
            $path = parse_url($value, PHP_URL_PATH) ?: '';

            return $path !== '' ? $path : $value;
        }

        return Str::startsWith($value, '/')
            ? $value
            : '/storage/' . ltrim($value, '/');
    }

    public function setAttachmentPathAttribute($value): void
    {
        if (!is_string($value) || $value === '') {
            $this->attributes['attachment_path'] = null;
            return;
        }

        if (Str::startsWith($value, ['http://', 'https://'])) {
            $path = parse_url($value, PHP_URL_PATH) ?: '';
            $value = Str::startsWith($path, '/storage/')
                ? Str::after($path, '/storage/')
                : $path;
        }

        $this->attributes['attachment_path'] = ltrim((string) $value, '/');
    }

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function sourcingRequest(): BelongsTo { return $this->belongsTo(SourcingRequest::class); }
}

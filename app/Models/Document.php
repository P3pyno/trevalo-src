<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Document extends Model {
    protected $fillable = ['user_id','sourcing_request_id','name','type','file_path','url','size'];

    public function getUrlAttribute($value): ?string {
        if ($this->file_path) {
            return '/storage/' . ltrim($this->file_path, '/');
        }

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

    public function setUrlAttribute($value): void
    {
        if (!is_string($value) || $value === '') {
            $this->attributes['url'] = null;
            return;
        }

        if (Str::startsWith($value, ['http://', 'https://'])) {
            $path = parse_url($value, PHP_URL_PATH) ?: '';
            $value = Str::startsWith($path, '/storage/')
                ? Str::after($path, '/storage/')
                : $path;
        }

        $this->attributes['url'] = ltrim((string) $value, '/');
    }

    public function sourcingRequest(): BelongsTo { return $this->belongsTo(SourcingRequest::class); }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
}

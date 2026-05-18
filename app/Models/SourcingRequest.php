<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use App\Traits\LogsActivity;

class SourcingRequest extends Model {
    use LogsActivity;
    
    protected $fillable = ['user_id','title','description','quantity','target_price','currency','destination_country','deadline','status','notes','product_images'];
    protected $casts = ['deadline' => 'date', 'target_price' => 'decimal:2', 'product_images' => 'array'];

    protected static function booted(): void {
        static::created(function (SourcingRequest $req) {
            $req->updateQuietly([
                'order_id' => 'ORD-' . str_pad($req->id, 5, '0', STR_PAD_LEFT),
            ]);
        });
    }

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function quotes(): HasMany { return $this->hasMany(Quote::class); }
    public function shipments(): HasMany { return $this->hasMany(Shipment::class); }
    public function documents(): HasMany { return $this->hasMany(Document::class); }
    public function messages(): HasMany { return $this->hasMany(Message::class)->orderBy('created_at'); }

    public function getProductImagesAttribute($value): array
    {
        $images = is_array($value) ? $value : (json_decode($value ?? '[]', true) ?: []);

        return array_values(array_filter(array_map(function ($image) {
            if (!is_string($image) || $image === '') {
                return null;
            }

            if (Str::startsWith($image, ['http://', 'https://'])) {
                $path = parse_url($image, PHP_URL_PATH) ?: '';

                return $path !== '' ? $path : $image;
            }

            if (Str::startsWith($image, '/storage/')) {
                return $image;
            }

            return '/storage/' . ltrim($image, '/');
        }, $images)));
    }

    public function setProductImagesAttribute($value): void
    {
        $images = is_array($value) ? $value : (json_decode($value ?? '[]', true) ?: []);

        $this->attributes['product_images'] = json_encode(array_values(array_filter(array_map(function ($image) {
            if (!is_string($image) || $image === '') {
                return null;
            }

            if (Str::startsWith($image, ['http://', 'https://'])) {
                $path = parse_url($image, PHP_URL_PATH) ?: '';

                return Str::startsWith($path, '/storage/')
                    ? ltrim(Str::after($path, '/storage/'), '/')
                    : ltrim($path, '/');
            }

            return Str::startsWith($image, '/storage/')
                ? ltrim(Str::after($image, '/storage/'), '/')
                : ltrim($image, '/');
        }, $images))));
    }
}

<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\LogsActivity;

class SourcingRequest extends Model {
    use LogsActivity;
    
    protected $fillable = ['user_id','title','description','quantity','target_price','currency','destination_country','deadline','status','notes','product_images'];
    protected $casts = ['deadline' => 'date', 'target_price' => 'decimal:2', 'product_images' => 'array'];

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function quotes(): HasMany { return $this->hasMany(Quote::class); }
    public function shipments(): HasMany { return $this->hasMany(Shipment::class); }
    public function documents(): HasMany { return $this->hasMany(Document::class); }
    public function messages(): HasMany { return $this->hasMany(Message::class)->orderBy('created_at'); }
}

<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model {
    protected $fillable = ['supplier_code', 'name', 'country', 'contact_email', 'notes'];

    protected static function booted(): void {
        static::created(function (Supplier $supplier) {
            $supplier->updateQuietly([
                'supplier_code' => 'SUP-' . str_pad($supplier->id, 5, '0', STR_PAD_LEFT),
            ]);
        });
    }

    public function quotes(): HasMany { return $this->hasMany(Quote::class); }
}

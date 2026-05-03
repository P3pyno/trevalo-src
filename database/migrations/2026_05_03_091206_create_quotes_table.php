<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sourcing_request_id')->constrained()->cascadeOnDelete();
            $table->string('supplier_name');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_price', 12, 2);
            $table->string('currency', 3)->default('USD');
            $table->integer('moq');
            $table->string('lead_time');
            $table->text('notes')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('quotes'); }
};

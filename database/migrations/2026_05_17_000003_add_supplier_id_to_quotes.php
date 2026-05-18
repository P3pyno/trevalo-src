<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('quotes', function (Blueprint $table) {
            $table->foreignId('supplier_id')->nullable()->after('sourcing_request_id')->constrained('suppliers')->nullOnDelete();
            $table->string('supplier_name')->nullable()->change();
        });
    }
    public function down(): void {
        Schema::table('quotes', function (Blueprint $table) {
            $table->dropForeign(['supplier_id']);
            $table->dropColumn('supplier_id');
        });
    }
};

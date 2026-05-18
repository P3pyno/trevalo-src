<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('quotes', function (Blueprint $table) {
            $table->dropColumn(['unit_price', 'total_price', 'currency']);
            $table->string('quote_file_path')->nullable()->after('lead_time');
        });
    }
    public function down(): void {
        Schema::table('quotes', function (Blueprint $table) {
            $table->dropColumn('quote_file_path');
            $table->decimal('unit_price', 10, 2)->after('supplier_name');
            $table->decimal('total_price', 12, 2)->after('unit_price');
            $table->string('currency', 3)->default('USD')->after('total_price');
        });
    }
};

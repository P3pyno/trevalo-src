<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('sourcing_requests', 'product_images')) {
            Schema::table('sourcing_requests', function (Blueprint $table) {
                $table->json('product_images')->nullable()->after('notes');
            });
        }

        if (!Schema::hasColumn('messages', 'attachment_path')) {
            Schema::table('messages', function (Blueprint $table) {
                $table->string('attachment_path')->nullable()->after('body');
                $table->string('attachment_name')->nullable()->after('attachment_path');
                $table->string('attachment_mime')->nullable()->after('attachment_name');
            });
        }

        if (!Schema::hasColumn('documents', 'user_id') || !Schema::hasColumn('documents', 'url')) {
            Schema::table('documents', function (Blueprint $table) {
                if (!Schema::hasColumn('documents', 'user_id')) {
                    $table->foreignId('user_id')->nullable()->after('id')->constrained()->nullOnDelete();
                }

                if (!Schema::hasColumn('documents', 'url')) {
                    $table->string('url')->nullable()->after('file_path');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('sourcing_requests', 'product_images')) {
            Schema::table('sourcing_requests', function (Blueprint $table) {
                $table->dropColumn('product_images');
            });
        }

        if (Schema::hasColumn('messages', 'attachment_path')) {
            Schema::table('messages', function (Blueprint $table) {
                $table->dropColumn(['attachment_path', 'attachment_name', 'attachment_mime']);
            });
        }

        if (Schema::hasColumn('documents', 'user_id') || Schema::hasColumn('documents', 'url')) {
            Schema::table('documents', function (Blueprint $table) {
                if (Schema::hasColumn('documents', 'user_id')) {
                    $table->dropForeign(['user_id']);
                }

                $dropColumns = [];

                if (Schema::hasColumn('documents', 'user_id')) {
                    $dropColumns[] = 'user_id';
                }

                if (Schema::hasColumn('documents', 'url')) {
                    $dropColumns[] = 'url';
                }

                if ($dropColumns !== []) {
                    $table->dropColumn($dropColumns);
                }
            });
        }
    }
};

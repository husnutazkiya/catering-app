<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('order', function (Blueprint $table) {
            if (!Schema::hasColumn('order', 'table_no')) {
                $table->string('table_no')->nullable()->after('menu_id');
            }
            if (!Schema::hasColumn('order', 'customer_name')) {
                $table->string('customer_name')->nullable()->after('table_no');
            }
            if (!Schema::hasColumn('order', 'customer_phone')) {
                $table->string('customer_phone')->nullable()->after('customer_name');
            }
            if (!Schema::hasColumn('order', 'order_type')) {
                $table->string('order_type')->default('delivery')->after('customer_phone');
            }
        });

        // Lepas foreign key lama user_id agar bisa dijadikan nullable
        try {
            Schema::table('order', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
            });
        } catch (\Exception $e) {
            // Lanjut jika foreign key telah dilepas
        }

        try {
            Schema::table('order', function (Blueprint $table) {
                $table->unsignedInteger('user_id')->nullable()->change();
                $table->foreign('user_id')->references('id')->on('users')->nullOnDelete()->onUpdate('cascade');
            });
        } catch (\Exception $e) {
            // Fallback raw MySQL
            try {
                DB::statement('ALTER TABLE `order` MODIFY `user_id` INT UNSIGNED NULL;');
            } catch (\Exception $ex) {
                // Abaikan jika sudah nullable
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order', function (Blueprint $table) {
            $table->dropColumn(['table_no', 'customer_name', 'customer_phone', 'order_type']);
        });
    }
};

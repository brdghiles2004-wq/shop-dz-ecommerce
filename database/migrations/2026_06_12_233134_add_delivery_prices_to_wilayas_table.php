<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('wilayas', function (Blueprint $table) {
        $table->decimal('home_price', 10, 2)->default(0)->after('shipping_price');
        $table->renameColumn('shipping_price', 'stopdesk_price');
    });
}

public function down(): void
{
    Schema::table('wilayas', function (Blueprint $table) {
        $table->dropColumn('home_price');
        $table->renameColumn('stopdesk_price', 'shipping_price');
    });
}


};

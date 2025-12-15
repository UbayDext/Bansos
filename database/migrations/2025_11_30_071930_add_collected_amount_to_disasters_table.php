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
    Schema::table('disasters', function (Blueprint $table) {
        $table->unsignedBigInteger('collected_amount')
              ->default(0)
              ->after('target_amount');
    });
}

public function down(): void
{
    Schema::table('disasters', function (Blueprint $table) {
        $table->dropColumn('collected_amount');
    });
}

};

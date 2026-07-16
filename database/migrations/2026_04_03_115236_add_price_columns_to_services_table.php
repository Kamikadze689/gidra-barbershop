<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->integer('price_men')->default(0);
            $table->integer('price_master')->default(0);
            $table->integer('price_top')->default(0);
        });
    }

    public function down()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['price_men', 'price_master', 'price_top']);
        });
    }
};

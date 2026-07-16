<?php
 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('masters', function (Blueprint $table) {
            $table->string('slug')->unique()->after('name')->nullable();
        });
        
         
        $masters = DB::table('masters')->get();
        foreach ($masters as $master) {
            DB::table('masters')
                ->where('id', $master->id)
                ->update(['slug' => Str::slug($master->name)]);
        }
        
         
        Schema::table('masters', function (Blueprint $table) {
            $table->string('slug')->unique()->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('masters', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
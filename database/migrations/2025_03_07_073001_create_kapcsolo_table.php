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
        Schema::create('kapcsolo', function (Blueprint $table) {
            $table->id();
            $table->foreignId("recept_id")->references("id")->on("receptek")->onDelete("cascade");
            $table->foreignId("hozzavalo_id")->references("id")->on("hozzavalok")->onDelete("cascade");
            $table->integer("mennyiseg");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kapcsolo');
    }
};

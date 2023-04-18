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
        Schema::create('main_menus', function (Blueprint $table) {
            $table->id();
            $table->string('mainMenu')->unique();
            $table->string('mainURI')->unique();
            $table->string('mainLocation')->nullable();
            $table->boolean('isEnabled')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('main_menus');
    }
};

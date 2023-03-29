<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('main_menu_id')->constrained('main_menus')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('sub_menu_id')->constrained('sub_menus')->restrictOnDelete()->cascadeOnUpdate();
            $table->string('title');
            $table->longText('content');
            $table->string('attachment')->nullable();
            $table->string('status')->default('denied');
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('mod_user_id')->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->boolean('isVisible');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contents');
    }
};

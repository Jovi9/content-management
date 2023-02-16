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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('employeeID');
            $table->string('firstName');
            $table->string('middleInitial')->nullable();
            $table->string('lastName');
            $table->foreignId('department_id')->constrained('departments')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('user_type_id')->constrained('user_types')->restrictOnDelete()->cascadeOnUpdate();
            $table->string('status')->default('enable');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};

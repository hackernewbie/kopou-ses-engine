<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kopou_suppression_list', function (Blueprint $table) {

            $table->id();

            $table->string('email')->unique();

            $table->string('reason')->nullable();
            $table->string('source')->nullable();

            $table->timestamp('suppressed_at')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kopou_suppression_list');
    }
};

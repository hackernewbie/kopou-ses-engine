<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kopou_list_contacts', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('list_id')->index();
            $table->unsignedBigInteger('contact_id')->index();

            $table->timestamps();

            $table->unique(['list_id', 'contact_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('kopou_list_contacts');
    }
};

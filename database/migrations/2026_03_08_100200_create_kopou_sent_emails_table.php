<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kopou_sent_emails', function (Blueprint $table) {

            $table->id();

            $table->string('email')->index();

            $table->string('subject')->nullable();

            $table->string('message_id')->nullable()->index();

            $table->string('configuration_set')->nullable();

            $table->json('metadata')->nullable();

            $table->timestamp('sent_at')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kopou_sent_emails');
    }
};

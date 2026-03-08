<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kopou_email_events', function (Blueprint $table) {

            $table->id();

            $table->string('email')->index();

            $table->string('event_type')->index();

            $table->string('message_id')->nullable()->index();

            $table->json('payload')->nullable();

            $table->timestamp('event_time')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kopou_email_events');
    }
};

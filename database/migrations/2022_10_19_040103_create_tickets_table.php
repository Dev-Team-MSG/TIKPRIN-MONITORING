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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string("no_ticket");
            $table->unsignedBigInteger("assign_to")->nullable();
            $table->unsignedBigInteger("owner");
            $table->unsignedBigInteger("category_ticket_id");
            $table->unsignedBigInteger("severity_id");
            $table->string("title");
            $table->string("description");
            $table->string("status")->default("open");
            $table->timestamp("close_datetime")->nullable();
            $table->timestamp("due_datetime")->nullable();
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
        Schema::dropIfExists('tickets');
    }
};

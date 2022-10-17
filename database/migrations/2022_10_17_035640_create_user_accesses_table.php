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
        Schema::create('user_access', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("role_id");
            $table->foreign("role_id")
                ->references("id")
                ->on("roles")
                ->onDelete("cascade");
            $table->unsignedBigInteger("menu_id");
            $table->foreign("menu_id")
                ->references("id")
                ->on("menus")
                ->onDelete("cascade");
            $table->boolean("view")->default(0);
            $table->boolean("add")->default(0);
            $table->boolean("edit")->default(0);
            $table->boolean("delete")->default(0);
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
        Schema::dropIfExists('user_access');
    }
};

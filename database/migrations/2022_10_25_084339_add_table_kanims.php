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
        Schema::create('kanims', function (Blueprint $table) {
            $table->id();
            $table->string('name',35);
            $table->string('network',50)->nullable();
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
        $table->dropColumn('id');
        $table->dropColumn('name');
        $table->dropColumn('network');
        $table->dropColumn('timestamps');
    }
};

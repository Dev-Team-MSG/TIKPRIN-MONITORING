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
        Schema::table('printers', function (Blueprint $table) {
            $table->date('tahun_pengadaan');
            $table->index('kanim_id')->default('1')->unsigned();
            $table->foreign('kanim_id')->references('id')->on('kanims')->onDelete('RESCRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('printers', function (Blueprint $table) {
            $table->dropForeign('lists_kanim_id_foreign');
            $table->dropIndex('lists_kanim_id_index');
            $table->dropColumn('kanim_id');
        });
    }
};

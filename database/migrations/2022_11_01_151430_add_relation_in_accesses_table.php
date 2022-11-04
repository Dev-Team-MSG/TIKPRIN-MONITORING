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
        Schema::table('accesses', function (Blueprint $table) {
            //
            $table->foreign("kode_menu")->references("kode_menu")->on("menus")->onDelete("cascade");
            $table->foreign("role_id")->references("id")->on("roles")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accesses', function (Blueprint $table) {
            //
            // $table->dropForeign("accesses_kode_menu_foreign");
            // $table->dropForeign("accesses_role_id_foreign");
            $table->dropColumn("kode_menu");
            $table->dropColumn("role_id");
        });
    }
};

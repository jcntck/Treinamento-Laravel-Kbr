<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RelacionamentoCategoriaUsuario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('usuarios', function($table) {
            $table->integer('categoria_id')->unsigned()->nullable();
        });

        Schema::table('usuarios', function($table) {
            $table->foreign('categoria_id')->
                references('id')->
                on('categorias')->
                onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('usuarios', function($table) {
            $table->dropForeign('usuarios_categoria_id_foreign');
            $table->dropColumn('categoria_id');
        });
    }
}

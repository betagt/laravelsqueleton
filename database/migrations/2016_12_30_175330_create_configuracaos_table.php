<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfiguracaosTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('configuracaos', function(Blueprint $table) {
            $table->increments('id');
            $table->string('titulo');
            $table->string('email')->nullable();
            $table->string('url_site')->nullable();
            $table->string('telefone')->nullable();
            $table->string('horario_atendimento')->nullable();
            $table->string('endereco')->nullable();
            $table->string('rodape')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('google_plus')->nullable();
            $table->string('youtube')->nullable();
            $table->string('instagram')->nullable();
            $table->string('palavra_chave')->nullable();
            $table->string('descricao_site')->nullable();
            $table->string('og_tipo_app')->nullable();
            $table->string('og_titulo_site')->nullable();
            $table->string('od_url_site')->nullable();
            $table->string('od_autor_site')->nullable();
            $table->string('facebook_id')->nullable();
            $table->string('token')->nullable();
            $table->string('analytcs_code')->nullable();
            $table->timestamps();
            $table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('configuracaos');
	}

}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $c = get_site_key('restApi');

        Schema::create('api_tokens', function (Blueprint $table) use ($c) {
            $table->bigIncrements('id');
            $table->string('name')->default( $c['token_name'] );
            $table->integer('user_id')->nullable();	
            $table->string('ip_adress');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('expiration_date')->nullable();
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
        Schema::dropIfExists('api_tokens');
    }
}

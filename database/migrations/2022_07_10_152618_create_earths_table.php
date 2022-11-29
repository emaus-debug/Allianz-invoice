<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEarthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('earths', function (Blueprint $table) {
            $table->id();
            $table->string('nature_marchandise');
            $table->string('mode_transport');
            $table->string('depart');
            $table->string('arrive');
            $table->string('distance');
            $table->string('moyen_transport');
            $table->string('conditionnement');
            $table->string('nbre_cam_voy');
            $table->string('garantie_chargement')->default(0);
            $table->string('transp_prof')->default(0);
            $table->string('etat_route')->default(0);
            $table->string('classe');
            $table->string('val_voyage');
            $table->string('prime');
            $table->string('prime_nette');
            $table->string('accessoire');
            $table->string('taxes');
            $table->enum('status', ['valide','soumis'])->default('soumis');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('user_id');

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('earths');
    }
}

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
        Schema::create('nrh_pieces', function (Blueprint $table) {
            $table->id();
            $table->integer('nominal');
            $table->integer('quantite');
            $table->timestamps();
            
            # Key
            $table->foreignId('caisse_id')
                ->nullable()
                ->constrained('nrh_caisses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nrh_pieces');
    }
};

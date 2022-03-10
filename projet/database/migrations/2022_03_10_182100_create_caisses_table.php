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
        Schema::create('nrh_caisses', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->text('note');
            $table->timestamps();

            # Key
            $table->foreignId('operation_id')
                ->nullable()
                ->constrained('nrh_operations')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nrh_caisses');
    }
};

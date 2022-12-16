<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['movie', 'book', 'disc']);
            $table->smallInteger('rate');
            $table->string('title', 40);
            $table->string('excerpt', 250);
            $table->text('message');
            $table->binary('thumbnail');
            $table->foreignId('idUser');
            
            $table->timestamps();
            
            $table->foreign('idUser')->references('id')->on('user')->onDelete('cascade');
        });
        $sql = 'alter table review change thumbnail thumbnail longblob';
        DB::statement($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('review');
    }
};

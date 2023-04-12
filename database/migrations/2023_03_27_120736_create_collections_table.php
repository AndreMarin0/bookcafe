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
        // Schema::create('collections', function (Blueprint $table) {
        //     $table->id('BookID');
        //     $table->timestamps();
        //     $table->string('Description',250);
        //     $table->bigInteger('AuthorID');
        //     $table->date('DatePublished')->default(now());
        //     $table->bigInteger('PubID');
        //     $table->bigInteger('GenID');
        // });
        Schema::create('collections', function (Blueprint $table) {
            $table->id('BookID');
            $table->timestamps();
            $table->string('Description', 250);
            $table->bigInteger('AuthorID')->unsigned();
            $table->date('DatePublished')->default(now());
            $table->bigInteger('PubID')->unsigned();
            $table->bigInteger('GenID')->unsigned();

            // $table->foreign('AuthorID')->references('AuthorID')->on('authors');
            // $table->foreign('PubID')->references('PubID')->on('publishers');
            // $table->foreign('GenID')->references('GenID')->on('genres');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('collections');
    }
};

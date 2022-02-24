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
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('idUser');
            $table->foreign('idUser')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('idSurvey');
            $table->foreign('idSurvey')->references('id')->on('surevies')->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('questionId');
            $table->foreign('questionId')->references('id')->on('questions')->onUpdate('cascade')->onDelete('cascade');

            $table->integer("score");
            $table->integer('totalScore');
            $table->longText("userAnswers");
          
            $table->unsignedBigInteger('commentid')->nullable();
            $table->foreign('commentid')->references('clarifications')->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('answers');
    }
};

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
        Schema::create('survey_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('surveyId');
            $table->foreign('surveyId')->references('id')->on('surevies')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('questionId');
            $table->foreign('questionId')->references('id')->on('questions')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('priority');
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
        Schema::dropIfExists('survey_questions');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('survey_questions', function (Blueprint $table) {
            $table->id();
            $table->string('variable', 100);
            $table->string('dimension', 100);
            $table->string('sub_dimension', 100)->nullable();
            $table->integer('order_number');
            $table->text('question_text');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('survey_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('respondent_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('question_id')->constrained('survey_questions')->cascadeOnDelete();
            $table->integer('score'); // 1-5 Likert
            $table->timestamp('responded_at');
            $table->timestamps();

            $table->unique(['respondent_id', 'question_id']);
            $table->index('respondent_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('survey_responses');
        Schema::dropIfExists('survey_questions');
    }
};

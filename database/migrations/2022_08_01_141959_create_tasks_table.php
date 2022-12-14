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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained();
            $table->enum('type', ['correct_answer', 'drag_and_drop', 'column_sorting', 'description', 'column_sorting_multiple', 'add_letter', 'sentence', 'complete_the_sentence', 'story', 'connect_lines', 'equations']);
            $table->smallInteger('distractor_level')->nullable();
            $table->string('description')->nullable();
            $table->json('content');
            $table->smallInteger('display_order');
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
        Schema::dropIfExists('tasks');
    }
};

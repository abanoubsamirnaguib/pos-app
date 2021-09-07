<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_translations', function (Blueprint $table) {
                // mandatory fields
       $table->bigIncrements('id'); // Laravel 5.8+ use bigIncrements() instead of increments()
       $table->string('locale')->index();

       // Foreign key to the main model
    //    $table->Integer('category_id')->unsigned();
       $table->unique(['category_id', 'locale']);
       
       $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');;

       // Actual fields you want to translate
       $table->string('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_translations');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->unsignedBigInteger('category_id');
            $table->string('title')->unique();
            $table->string('thumbnail');
            $table->enum('status', ['published', 'draft']);
            $table->longText('content');
            $table->unsignedBigInteger('createdBy');
            $table->unsignedBigInteger('updatedBy');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('updatedBy')->references('id')->on('users');
            $table->foreign('createdBy')->references('id')->on('users');
            $table->timestamp('published_at')->nullable();
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
        Schema::dropIfExists('news');
    }
}

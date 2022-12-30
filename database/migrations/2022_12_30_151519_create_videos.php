<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('netflix_id')->unique();
            $table->enum('type', ['movie', 'show']);
            $table->string('name');
            $table->integer('release_year', unsigned: true);
            $table->text('synopsis');
            $table->string('genres');
            $table->string('tags');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('videos');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLibbooksTable extends Migration
{
    public function up()
    {
        Schema::create('libbooks', function (Blueprint $table) {
            $table->increments('id');

            $table->string('lib_no')->nullable();

            $table->string('book_name')->nullable();

            $table->string('author_name')->nullable();

            $table->date('add_date')->nullable();

            $table->longText('book_detail')->nullable();

            $table->timestamps();

            $table->softDeletes();
        });
    }
}

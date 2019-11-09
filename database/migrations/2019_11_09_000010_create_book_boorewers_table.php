<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookBoorewersTable extends Migration
{
    public function up()
    {
        Schema::create('book_boorewers', function (Blueprint $table) {
            $table->increments('id');

            $table->string('issue')->nullable();

            $table->string('due_date')->nullable();

            $table->string('return_date')->nullable();

            $table->string('book_name')->nullable();

            $table->timestamps();

            $table->softDeletes();
        });
    }
}

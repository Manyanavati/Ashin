<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');

            $table->string('phone_no');

            $table->string('address');

            $table->string('member_start_date')->nullable();

            $table->string('member_end_date')->nullable();

            $table->string('member_type');

            $table->timestamps();

            $table->softDeletes();
        });
    }
}

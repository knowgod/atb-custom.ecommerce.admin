<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvitationsTable extends Migration
{
    /**
      * Run the migrations.
      *
      * @return void
      */
     public function up()
     {
         Schema::drop('invites');
         Schema::create('invitations', function (Blueprint $table) {
             $table->increments('id');
             $table->string('email')->unique();
             $table->tinyInteger('status')->comment('Sent & inactive = 0; sent and active = 1');
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
         Schema::drop('invitations');
         Schema::create('invites', function (Blueprint $table) {
             $table->increments('id');
             $table->string('email')->unique();
             $table->tinyInteger('status')->comment('Sent & inactive = 0; sent and active = 1');
             $table->timestamps();
         });
     }
}

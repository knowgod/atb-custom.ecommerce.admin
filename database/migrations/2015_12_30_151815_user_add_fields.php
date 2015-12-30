<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserAddFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->string('google_id', 255)->nullable()->default(null);
            $table->string('google_avatar_img', 255)->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return voi
     */
    public function down()
    {
        Schema::table('users', function ($table) {
            $table->dropColumn('google_id');
            $table->dropColumn('google_avatar_img');
        });
    }
}

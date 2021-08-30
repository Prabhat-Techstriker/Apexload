<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone_number')->unique()->nullable();
            $table->boolean('email_verify')->default(0);
            $table->boolean('phone_verify')->default(0);
            $table->integer('user_role')->nullable();
            $table->integer('responsibilty_type')->nullable();
            $table->integer('account_type')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('preferred_origin')->nullable();
            $table->string('preferred_destination')->nullable();
            $table->string('home_location')->nullable();
            $table->string('licence')->nullable();
            $table->string('address')->nullable();
            $table->string('package_id')->nullable();
            $table->string('password')->nullable();
            $table->string('device_token')->nullable();
            $table->string('remember_token')->nullable();
            $table->string('verification_code')->unique()->nullable();
            $table->string('activation_token')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('users');
    }
}
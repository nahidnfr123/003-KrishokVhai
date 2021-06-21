<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('mobile_number')->unique()->nullable();
            $table->dateTime('dob')->nullable();
            $table->string('gender')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('avatar')->default('/storage/images/users/default.png');
            $table->integer('postal_code')->nullable();
            $table->enum("status", ["active", "pending", "blocked"])->default('active');
            $table->string('social_id')->nullable();
            $table->string('social_provider')->nullable();
            $table->text('about')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
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

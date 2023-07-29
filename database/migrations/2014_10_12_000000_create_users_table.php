<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('avatar')->nullable();
            $table->string('dob')->nullable();
            $table->string('nid_number');
            $table->string('income');
            $table->string('profession');
            $table->string('education');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->unsignedInteger('score')->default(0);

            $table->boolean('parent_is_alive')->default(false);
            $table->boolean('parent_available')->nullable();
            $table->string('parent_profession')->nullable();

            $table->boolean('spouse_is_alive')->default(false);
            $table->string('spouse_name')->nullable();
            $table->string('spouse_dob')->nullable();
            $table->string('spouse_nid_number')->nullable();
            $table->string('spouse_income')->nullable();
            $table->string('spouse_profession')->nullable();
            $table->string('spouse_education')->nullable();

            $table->unsignedInteger('no_of_child')->default(0);
            $table->string('children_profession')->nullable();

            $table->boolean('own_house')->default(true);
            $table->unsignedInteger('total_land')->default(0);
            $table->string('house_made_of');

            $table->boolean('other_earning_member')->default(true);
            $table->boolean('other_member_have_bank_account')->default(true);
            $table->string('status')->nullable();

            $table->rememberToken();
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
};

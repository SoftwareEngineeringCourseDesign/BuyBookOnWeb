<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->comment('用户名')->nullable()->unique();
            $table->string('password')->comment('密码')->nullable();
            $table->string('email')->comment('邮箱')->nullable()->unique();
            $table->integer('role_id')->comment('身份')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('user')->insert([
            [
                'username' => 'root',
                'password' => app('hash')->make(shal('root')),
                'email' => 'admin@example.com',
                'role_id' => '1',
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}

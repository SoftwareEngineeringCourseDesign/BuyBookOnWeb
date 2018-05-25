<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('用户角色名称')->nullable();
            $table->string('alias')->comment('用户角色别名')->nullable()->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('role')->insert([
            [
                'name' => '站长',
                'alias' => 'root',
            ],
            [
                'name' => '个人',
                'alias' => 'person'
            ],
            [
                'name' => '书商',
                'alias' => 'bookseller'
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role');
    }
}

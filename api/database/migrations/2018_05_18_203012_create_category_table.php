<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('分类名称')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('category')->insert([
            [
                'name' => '文学',
            ],
            [
                'name' => '小说'
            ],
            [
                'name' => '传记'
            ],
            [
                'name' => '少儿'
            ],
            [
                'name' => '政治与军事'
            ],
            [
                'name' => '哲学与宗教'
            ],
            [
                'name' => '心理学'
            ],
            [
                'name' => '历史'
            ],
            [
                'name' => '法律'
            ],
            [
                'name' => '经济'
            ],
            [
                'name' => '教辅'
            ],
            [
                'name' => '计算机与互联网'
            ],
            [
                'name' => '旅游与地图'
            ],
            [
                'name' => '运动健身'
            ],
            [
                'name' => '养生保健'
            ],
            [
                'name' => '烹饪美食'
            ],
            [
                'name' => '期刊杂志'
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
        Schema::dropIfExists('category');
    }
}

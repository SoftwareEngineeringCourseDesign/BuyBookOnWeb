<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArchiveSellerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('archive_seller', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->text('attachments')->comment('附件文件名（json数组）')->nullable();
            $table->integer('passed')->comment('审核')->nullable();
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
        Schema::dropIfExists('archive_seller');
    }
}

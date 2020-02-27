<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchandiseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchandise', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('category');
            
            // -C (Create) : 建立中; -S (Sell) : 可販售
            $table->string('status', 1)->default('C');
            $table->string('name', 80)->nullable();
            $table->text('introduction')->nullable();
            $table->string('photo', 50)->nullable();
            $table->integer('price')->default(0);
            $table->integer('remain_count')->default(0);

            $table->integer('customer_id');
            $table->timestamps();

            //索引設定
            $table->index(['status'], 'merchandise_status_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Schema::dropIfExists('products');
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}

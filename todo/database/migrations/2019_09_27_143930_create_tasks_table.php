<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('folder_id')->unsigned();
            $table->string('title', 100);
            $table->date('due_date');
            $table->integer('status')->default(1);  //タスクを作成した最初の状態は必ず「未着手」状態でしょうから、何も指定しないときは「1」が入るようにしておきます。
            $table->timestamps();

            // 外部キーを設定する
            $table->foreign('folder_id')->references('id')->on('folders');
            //外部キー制約は他のテーブルとの結びつきを表現するためのカラムに設定します。外部キー制約が設定されたカラムには、好き勝手な値は入れられなくなります。今回の例で言うと、タスクテーブルのフォルダID列には実際に存在するフォルダIDの値しか入れることができなくなります。これによりデータの不整合を防ぐ
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabelTableWithPivot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label')->unique();
            $table->timestamps();
        });

        Schema::create('labels_tasks', function (Blueprint $table) {
            $table->bigInteger('label_id')->unsigned();
            $table->bigInteger('task_id')->unsigned();

            $table->primary(['label_id', 'task_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('labels');
        Schema::dropIfExists('labels_tasks');
    }
}

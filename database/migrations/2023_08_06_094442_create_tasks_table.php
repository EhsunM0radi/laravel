<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->unsignedBigInteger('creator');
            $table->foreign('creator')->references('id')->on('users')->onDelete('Cascade')->onUpdate('Cascade');
            $table->unsignedBigInteger('project_id'); // Foreign key column

            // Define foreign key constraint
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('parent')->nullable(true);
            $table->foreign('parent')->references('id')->on('tasks')->onDelete('Cascade')->onUpdate('Cascade');
            $table->unsignedBigInteger('estimate')->default(20);
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
        Schema::dropIfExists('tasks');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCalledSpokenToTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {

            $table->tinyInteger('called')->after('spoken')->nullable();
            $table->dateTime('next_call')->after('called')->nullable();
            $table->string('snooze')->after('next_call')->nullable();
            $table->string('task_priority')->after('snooze')->nullable();
            $table->string('task_priority_name')->after('task_priority')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn([
                'called', 'next_call', 'snooze', 'task_priority', 'task_priority_name'
            ]);
        });
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEventColumnToActivityLogTable extends Migration
{
    public function up()
    {
        Schema::connection(config('activitylog.database_connection'))->table(config('activitylog.table_name'), function (Blueprint $table) {
            if ($this->isMySQL()) {
                $table->string('event')->nullable()->after('subject_type');
                // $column->after('properties');
            }
        });
    }

    public function down()
    {
        Schema::connection(config('activitylog.database_connection'))->table(config('activitylog.table_name'), function (Blueprint $table) {
            $table->dropColumn('event');
        });
    }

    private function isMySQL(): bool
    {
        return Schema::connection(config('activitylog.database_connection'))->getConnection()->getDriverName() === 'mysql';
    }
}

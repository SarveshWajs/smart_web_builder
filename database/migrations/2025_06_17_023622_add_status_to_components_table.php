<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToComponentsTable extends Migration
{
    public function up()
    {
        Schema::table('components', function (Blueprint $table) {
            $table->boolean('status')->default(true)->after('name');
        });
    }

    public function down()
    {
        Schema::table('components', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}

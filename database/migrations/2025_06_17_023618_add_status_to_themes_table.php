<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToThemesTable extends Migration
{
    public function up()
    {
        Schema::table('themes', function (Blueprint $table) {
           $table->boolean('status')->default(true)->after('name');
        });
    }

    public function down()
    {
        Schema::table('themes', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}

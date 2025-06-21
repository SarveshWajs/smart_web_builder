<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
public function up()
{
    Schema::create('components', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->text('html');
        $table->text('css')->nullable();
        $table->text('js')->nullable(); // Add this line for JavaScript code
        $table->json('images')->nullable();
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
        Schema::dropIfExists('components');
    }
}

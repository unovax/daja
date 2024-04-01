<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('works', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients');
            $table->decimal('total', 8, 2)->nullalbe()->default(0);
            $table->decimal('paid', 8, 2)->nullalbe()->default(0);
            $table->decimal('balance', 8, 2)->nullalbe()->default(0);
            $table->string('status')->default('P');
            $table->string('type')->default('work');
            $table->string('description')->nullable();
            $table->datetime('date')->nullable();
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
        Schema::dropIfExists('works');
    }
};

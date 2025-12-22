<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customer_agents', function (Blueprint $table) {
            $table->id();
            $table->string('agent_name');
            $table->string('product');
            $table->integer('no_product');
            $table->string('customer');
            $table->string('phone');
            $table->enum('flag', ['0', '1'])->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_agents');
    }
};

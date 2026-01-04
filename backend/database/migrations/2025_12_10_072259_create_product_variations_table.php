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
        Schema::create('product_variations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('color')->nullable();
            $table->string('size')->nullable();
            $table->string('sku')->nullable()->unique();
            $table->decimal('price', 10, 2)->nullable();
            $table->integer('stock')->default(0);
            $table->timestamps();
            
            // quick index to search variants
            $table->index(['product_id', 'color', 'size']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variations');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enum\Product\ProductStatusEnum;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->foreignId('vendor_id')
                 ->references('id')->on('users')
                ->restrictOnDelete();
                  $table->foreignId('category_id')
                ->references('id')->on('categories')->onDelete('cascade');

            $table->foreignId('subcategory_id')
                ->references('id')->on('subcategories')->onDelete('cascade');

            $table->string('name');
            $table->string('slug')->unique();
            $table->string('description');

            $table->decimal('price');

            $table->string('status')->default(ProductStatusEnum::DRAFT->value);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

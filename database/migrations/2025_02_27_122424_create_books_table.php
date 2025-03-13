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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("title");
            $table->string("author");
            $table->text("description");
            $table->double("price");
            $table->integer("stock")->nullable();
            $table->boolean("e_book")->default(false); // Fixed column name
            $table->binary("ebook_file")->nullable(); // Added for storing e-book PDFs
            $table->string("image");
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};

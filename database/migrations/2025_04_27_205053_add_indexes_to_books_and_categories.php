<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->index('title', 'books_title_index'); // Index for title
        });

        // Add index for description with key length
        DB::statement('CREATE INDEX books_description_index ON books (description(255))');

        Schema::table('categories', function (Blueprint $table) {
            $table->index('name', 'categories_name_index'); // Index for name
        });

        // Add index for description with key length
        DB::statement('CREATE INDEX categories_description_index ON categories (description(255))');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropIndex('books_title_index'); // Drop index for title
        });

        // Drop index for description
        DB::statement('DROP INDEX books_description_index ON books');

        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex('categories_name_index'); // Drop index for name
        });

        // Drop index for description
        DB::statement('DROP INDEX categories_description_index ON categories');
    }
};

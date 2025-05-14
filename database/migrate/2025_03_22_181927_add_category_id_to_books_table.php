<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // First, create a default category if it doesn't exist
        $defaultCategory = Category::firstOrCreate(
            ['name' => 'Uncategorized'],
            ['description' => 'Default category for existing books']
        );

        // Add the category_id column without foreign key constraint
        Schema::table('books', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->after('id')->nullable();
        });

        // Update existing books to use the default category
        DB::table('books')->update(['category_id' => $defaultCategory->id]);

        // Now add the foreign key constraint
        Schema::table('books', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
};

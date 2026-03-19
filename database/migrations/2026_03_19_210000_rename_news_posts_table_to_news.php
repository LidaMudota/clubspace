<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('news_posts') && ! Schema::hasTable('news')) {
            Schema::rename('news_posts', 'news');
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('news') && ! Schema::hasTable('news_posts')) {
            Schema::rename('news', 'news_posts');
        }
    }
};

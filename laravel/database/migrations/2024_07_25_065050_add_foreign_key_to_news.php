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
        Schema::table('news', function (Blueprint $table) {
            // Переконайтесь, що стовпець category_id існує та має правильний тип даних
            $table->unsignedBigInteger('category_id')->change();

            // Додаємо індекс перед додаванням зовнішнього ключа
            $table->index('category_id');

            // Додаємо зовнішній ключ, який посилається на таблицю categories
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropIndex(['category_id']);
        });
    }
};

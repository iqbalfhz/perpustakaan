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
        Schema::disableForeignKeyConstraints();

        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained();
            $table->foreignId('book_id')->constrained();
            $table->dateTime('loaned_at');
            $table->dateTime('due_at');
            $table->dateTime('returned_at')->nullable();
            $table->enum('status', ["dipinjam","hilang","rusak","normal"]);
            $table->enum('book_condition', ['normal', 'rusak', 'hilang'])->default('normal');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};

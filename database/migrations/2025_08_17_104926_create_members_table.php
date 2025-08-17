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

        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('nim_nip', 50)->unique();
            $table->string('email', 100)->unique();
            $table->string('phone', 20)->nullable();
            $table->string('address', 255)->nullable();
            $table->date('registered_at');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};

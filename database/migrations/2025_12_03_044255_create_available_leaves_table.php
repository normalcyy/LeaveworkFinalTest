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
        Schema::create('available_leaves', function (Blueprint $table) {
            $table->id(); // equivalent to `id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY`
            $table->unsignedBigInteger('user_id');
            $table->enum('leave_type', ['vacation', 'sick', 'personal', 'emergency']);
            $table->integer('total_requests')->default(0);
            $table->integer('submitted_requests')->default(0);
            $table->integer('remaining_requests')->default(0);
            $table->year('year');
            $table->timestamps(); // creates `created_at` and `updated_at` with default CURRENT_TIMESTAMP behavior

            // Optional: add foreign key if you have users table
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('available_leaves');
    }
};

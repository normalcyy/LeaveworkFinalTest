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
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->enum('leave_type', ['vacation', 'sick', 'personal', 'emergency']);
            $table->enum('priority', ['normal', 'urgent', 'emergency'])->default('normal');
            $table->date('start_date');
            $table->date('end_date');
            $table->text('reason');
            $table->string('message', 255)->nullable();
            $table->string('emergency_contact', 100)->nullable();
            $table->string('handover_to', 100)->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // Index on user_id for better query performance
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_requests');
    }
};

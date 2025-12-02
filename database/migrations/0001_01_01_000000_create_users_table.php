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
    public function up(): void
    {
        // Drop old tables if they exist
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('cache');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('users');
        Schema::enableForeignKeyConstraints();

        // Create the users table
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('emp_id', 20);
            $table->string('first_name', 50);
            $table->string('middle_name', 50)->nullable();
            $table->string('last_name', 50);
            $table->string('email', 100);
            $table->enum('role', ['employee','admin','superuser'])->default('employee');
            $table->string('position', 100)->nullable();
            $table->string('department', 50)->nullable();
            $table->string('company', 100)->nullable();
            $table->string('password_hash', 255);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        // Insert predefined users with the same password hash
        $passwordHash = '$2y$10$MKmHkhdxuhlG9F9hI7W8AeUp14VKCYiyjOZv3MuYdnlHcFCM8YzH2';

        DB::table('users')->insert([
            [
                'id' => 1,
                'emp_id' => 'ADM001',
                'first_name' => 'Admin',
                'middle_name' => 'A.',
                'last_name' => 'User',
                'email' => 'admin@test.com',
                'role' => 'admin',
                'position' => 'Administrator',
                'department' => 'IT',
                'company' => 'UC',
                'password_hash' => $passwordHash,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'emp_id' => 'SU001',
                'first_name' => 'Super',
                'middle_name' => '',
                'last_name' => 'User',
                'email' => 'su@test.com',
                'role' => 'superuser',
                'position' => 'Supervisor',
                'department' => 'IT',
                'company' => 'UC',
                'password_hash' => $passwordHash,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'emp_id' => 'EMP001',
                'first_name' => 'Employee',
                'middle_name' => '',
                'last_name' => 'Test',
                'email' => 'emp@test.com',
                'role' => 'employee',
                'position' => 'Network Engineer',
                'department' => 'IT',
                'company' => 'UC',
                'password_hash' => $passwordHash,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

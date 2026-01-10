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
        Schema::table('tourists', function (Blueprint $table) {

            // Additional Registration Fields
            $table->string('address')->nullable()->after('phone');
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('address');
            $table->date('date_of_birth')->nullable()->after('gender');
            $table->string('nationality')->nullable()->after('date_of_birth');
            $table->string('nid_passport')->nullable()->after('nationality');

            // Auth related
            $table->timestamp('email_verified_at')->nullable()->after('nid_passport');
            $table->rememberToken()->after('email_verified_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tourists', function (Blueprint $table) {
            $table->dropColumn([
                'address',
                'gender',
                'date_of_birth',
                'nationality',
                'nid_passport',
                'email_verified_at',
                'remember_token',
            ]);
        });
    }
};

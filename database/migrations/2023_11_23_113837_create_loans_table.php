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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('borrower_id');
            $table->unsignedBigInteger('loan_type_id')->nullable();
            $table->enum('loan_status',['pending','approved','rejected','disbursed','completed'])->default('pending');
            $table->decimal('principal_amount', 10, 2);
            $table->string('loan_release_date')->nullabe();
            $table->string('loan_duration')->nullable();
            $table->string('duration_period')->nullable();
            $table->string('transaction_reference')->nullable();
            $table->foreign('borrower_id')->references('id')->on('borrowers')->onDelete('cascade');
            $table->foreign('loan_type_id')->references('id')->on('loan_types')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};

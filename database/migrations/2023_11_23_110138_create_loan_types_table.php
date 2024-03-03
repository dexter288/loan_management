<?php

use App\Models\LoanType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('loan_types', function (Blueprint $table) {
            $table->id();
            $table->string('loan_name');
            $table->decimal('interest_rate', 10, 2);
            $table->string('interest_cycle');
            $table->timestamps();
        });

        // insert default loan types
        LoanType::insert([
            ['loan_name' => 'Buy Stock', 'interest_rate' => 5, 'interest_cycle' => 'monthly'],
            ['loan_name' => 'Expand Business', 'interest_rate' => 5, 'interest_cycle' => 'monthly'],
            ['loan_name' => 'Start-Up Costs', 'interest_rate' => 5, 'interest_cycle' => 'monthly'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_types');
    }
};

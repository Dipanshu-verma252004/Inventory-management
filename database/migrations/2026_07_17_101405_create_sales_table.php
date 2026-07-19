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
    Schema::create('sales', function (Blueprint $table) {

        $table->id();

        $table->foreignId('customer_id')
            ->constrained()
            ->cascadeOnUpdate()
            ->restrictOnDelete();

        $table->string('sale_no')->unique();

        $table->string('invoice_no')->nullable();

        $table->date('sale_date');

        $table->decimal('total_amount',12,2)->default(0);

        $table->decimal('paid_amount',12,2)->default(0);

        $table->decimal('due_amount',12,2)->default(0);

        $table->boolean('status')->default(1);

        $table->softDeletes();

        $table->timestamps();

    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};

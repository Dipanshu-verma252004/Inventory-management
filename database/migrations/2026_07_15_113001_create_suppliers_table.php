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
    Schema::create('suppliers', function (Blueprint $table) {

        $table->id();

        $table->string('supplier_name');

        $table->string('company_name')->nullable();

        $table->string('contact_person')->nullable();

        $table->string('gst_number')->nullable();

        $table->string('phone',20);

        $table->string('alternate_phone',20)->nullable();

        $table->string('email')->nullable();

        $table->string('website')->nullable();

        $table->text('address')->nullable();

        $table->string('city')->nullable();

        $table->string('state')->nullable();

        $table->string('country')->nullable();

        $table->string('postal_code')->nullable();

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
        Schema::dropIfExists('suppliers');
    }
};

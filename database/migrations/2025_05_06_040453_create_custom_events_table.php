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
         Schema::create('custom_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_request_id')->constrained('event_requests');
            $table->foreignId('organizer_id')->constrained('users');
            $table->date('finalized_date')->nullable();
            $table->decimal('total_price', 12, 2);
            $table->text('notes')->nullable();
            $table->enum('status', ['draft', 'confirmed', 'cancelled'])->default('draft');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_events');
    }
};

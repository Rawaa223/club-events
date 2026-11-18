<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Pivot table: which members attend which events.
     * Laravel's naming convention: both model names, singular, alphabetical order.
     */
    public function up(): void
    {
        Schema::create('event_member', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['event_id', 'member_id']); // a member can't register twice
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_member');
    }
};

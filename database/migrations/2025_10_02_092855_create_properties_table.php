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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->constrained()->onDelete('cascade');
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->foreignId('property_type_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->integer('price');
            $table->string('featured_photo');
            $table->string('purpose');
            $table->integer('bedroom');
            $table->integer('bathroom');
            $table->integer('garage')->nullable();
            $table->integer('size');
            $table->integer('floor')->nullable();
            $table->integer('balcony')->nullable();
            $table->string('address');
            $table->integer('built_year')->nullable();
            $table->text('map')->nullable();
            $table->boolean('is_featured')->default(0);
            $table->boolean('status')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};

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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('identification', 40);
            $table->date('birth_date');
            $table->string('phone', 15);
            $table->string('email', 30)->unique();
            $table->timestamps();
        });

        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('brand', 10);
            $table->string('model', 40);
            $table->string('plate_number', 7)->unique();
            $table->string('chassis_number', 20);
            $table->string('color', 30);
            $table->integer('km');
            $table->timestamps();
        });

        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('number', 10);
            $table->dateTime('date_start');
            $table->dateTime('date_end');
            $table->char('office_pickup', 4);
            $table->char('office_return', 4);
            $table->foreignId('vehicle_id')->constrained();
            $table->integer('km_pickup');
            $table->integer('km_return')->nullable();
            $table->foreignId('customer_id')->constrained();
            $table->timestamps();
        });

        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->binary('file');
            $table->dateTime('date_start');
            $table->dateTime('date_end');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
        Schema::dropIfExists('vehicles');
        Schema::dropIfExists('contracts');
        Schema::dropIfExists('reports');
    }
};

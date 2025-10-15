<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('occupation_id')->nullable()->constrained('occupations')->nullOnDelete();
            $table->foreignId('civil_status_id')->nullable()->constrained('civil_statuses')->nullOnDelete();
            $table->foreignId('ciudadano_id')->nullable()->constrained('ciudadanos')->nullOnDelete();
            $table->foreignId('phone_id')->nullable()->constrained('phones')->nullOnDelete();
            $table->foreignId('address_id')->nullable()->constrained('addresses')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('profiles');
    }
};

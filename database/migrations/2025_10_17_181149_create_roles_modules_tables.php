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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->timestamps();
        });

        Schema::create('modulos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->boolean('estatus')->default(true);
            $table->timestamps();
        });

        Schema::create('permisos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('modulo_id')
                ->constrained('modulos')
                ->onDelete('cascade');
            $table->string('nombre');
            $table->boolean('estatus');
            $table->timestamps();

            $table->unique(['modulo_id', 'nombre']);
        });

        Schema::create('rol_permiso', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rol_id')
                ->constrained('roles')
                ->onDelete('cascade');
            $table->foreignId('permiso_id')
                ->constrained('permisos')
                ->onDelete('cascade');

            $table->unique(['rol_id', 'permiso_id']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('rol_id')
                ->nullable()
                ->after('email')
                ->constrained('roles')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rol_permiso');
        Schema::dropIfExists('permisos');
        Schema::dropIfExists('modulos');
        Schema::dropIfExists('roles');

        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('rol_id');
            $table->dropColumn('rol_id');
        });
    }
};

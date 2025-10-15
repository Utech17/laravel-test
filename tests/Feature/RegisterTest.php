<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Ciudadano;
use App\Models\User;
use App\Models\Profile;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function registro_nuevo_crea_ciudadano_y_user()
    {
        // No hay ciudadano previo
        $payload = [
            'nacionalidad' => 'V',
            'cedula' => '12345678',
            'primer_nombre' => 'Juan',
            'primer_apellido' => 'Perez',
            'email' => 'juan@example.test',
            'email_confirmation' => 'juan@example.test',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
            'prefix' => '412',
            'phone_number' => '5551234',
            // dirección mínima
            'urbanizacion' => 'Urb',
            'calle' => 'Calle 1',
            'numero_casa' => '10',
            // referencias
            'estado_civil' => 'soltero',
            'ocupacion' => 'empleado',
        ];

        $response = $this->post(route('register'), $payload);

        $response->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('ciudadanos', ['cedula' => '12345678']);
        $this->assertDatabaseHas('users', ['email' => 'juan@example.test']);
    }

    /** @test */
    public function registro_con_ciudadano_existente_sin_profile_asocia_y_crea_usuario()
    {
        $ci = Ciudadano::create([
            'nacionalidad' => 'V',
            'cedula' => '87654321',
            'primer_nombre' => 'Ana',
            'primer_apellido' => 'Lopez',
        ]);

        $payload = [
            'nacionalidad' => 'V',
            'cedula' => '87654321',
            'primer_nombre' => 'Ana',
            'primer_apellido' => 'Lopez',
            'email' => 'ana@example.test',
            'email_confirmation' => 'ana@example.test',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
            'prefix' => '412',
            'phone_number' => '5555678',
            'urbanizacion' => 'Urb',
            'calle' => 'Calle 2',
            'numero_casa' => '20',
            'estado_civil' => 'casado',
            'ocupacion' => 'empleado',
        ];

        $response = $this->post(route('register'), $payload);
        $response->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('ciudadanos', ['cedula' => '87654321']);
        $this->assertDatabaseHas('users', ['email' => 'ana@example.test']);
        // profile debe existir y apuntar al ciudadano
        $this->assertDatabaseHas('profiles', ['ciudadano_id' => $ci->id]);
    }

    /** @test */
    public function intento_registro_con_ciudadano_con_profile_devuelve_error()
    {
        $user = User::factory()->create(['email' => 'exist@example.test']);
        $ci = Ciudadano::create([
            'nacionalidad' => 'V',
            'cedula' => '55555555',
            'primer_nombre' => 'Carlos',
            'primer_apellido' => 'Diaz',
        ]);

        // Asociamos profile existente
        Profile::create([
            'user_id' => $user->id,
            'ciudadano_id' => $ci->id,
        ]);

        $payload = [
            'nacionalidad' => 'V',
            'cedula' => '55555555',
            'primer_nombre' => 'Carlos',
            'primer_apellido' => 'Diaz',
            'email' => 'nuevo@example.test',
            'email_confirmation' => 'nuevo@example.test',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
            'prefix' => '412',
            'phone_number' => '5559999',
            'urbanizacion' => 'Urb',
            'calle' => 'Calle 3',
            'numero_casa' => '30',
            'estado_civil' => 'soltero',
            'ocupacion' => 'empleado',
        ];

        $response = $this->post(route('register'), $payload);

        // Debe volver con errores en la sesión
        $response->assertSessionHasErrors('cedula');
        $this->assertDatabaseMissing('users', ['email' => 'nuevo@example.test']);
    }
}

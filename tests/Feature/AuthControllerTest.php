<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * Este teste de feature valida o fluxo de autenticação (login e logout)
 * utilizando o AuthController.
 */
class AuthControllerTest extends TestCase
{
    // Usa um banco de dados limpo para cada teste
    use RefreshDatabase;

    /**
     * Garante que a página de login pode ser acessada.
     */
    #[Test]
    public function the_login_page_can_be_rendered()
    {
        $response = $this->get('/login');
        // Verifica se a requisição retorna status 200 (OK)
        $response->assertStatus(200);
        // Verifica se a view correta é retornada
        $response->assertViewIs('auth.login');
    }

    /**
     * Simula um login com credenciais válidas e verifica a autenticação.
     */
    #[Test]
    public function a_user_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'teste@exemplo.com',
            'password' => bcrypt('senha123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'teste@exemplo.com',
            'password' => 'senha123',
        ]);

        // Verifica se o usuário foi autenticado
        $this->assertAuthenticatedAs($user);
        // Redireciona para a página principal
        $response->assertRedirect('/');
    }

    /**
     * Simula um login com credenciais inválidas e verifica se a autenticação falha.
     */
    #[Test]
    public function a_user_cannot_login_with_invalid_credentials()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'senha-errada',
        ]);

        // Verifica que o usuário não foi autenticado
        $this->assertGuest();
        // Verifica se há um erro na sessão para o campo de email
        $response->assertSessionHasErrors('email');
    }

    /**
     * Garante que um usuário não autenticado é redirecionado para a página de login.
     */
    #[Test]
    public function unauthenticated_users_are_redirected_to_login()
    {
        // Simula acesso a uma rota protegida
        $response = $this->get('/profile/edit');

        // Verifica se o usuário é redirecionado
        $response->assertRedirect('/login');
    }

    /**
     * Simula o logout de um usuário autenticado.
     */
    #[Test]
    public function an_authenticated_user_can_logout()
    {
        $user = User::factory()->create();

        // Simula que um usuário já está logado
        $this->actingAs($user);

        $response = $this->post('/logout');

        // Verifica se o usuário foi deslogado
        $this->assertGuest();
        // Redireciona para a página de login
        $response->assertRedirect('/login');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Exibe a página de perfil do usuário.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        return view('profile.profile', [
            'title' => 'Detalhes do Perfil',
            'user' => Auth::user(),
            'editMode' => false,
            'customClass' => 'show-mode',
            'disabled' => 'disabled',
            'hidden' => 'hidden',
        ]);
    }

    /**
     * Exibe o formulário de edição do perfil do usuário.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function edit(Request $request)
    {
        return view('profile.profile', [
            'title' => 'Editar Perfil',
            'user' => Auth::user(),
            'editMode' => true,
            'customClass' => '',
            'disabled' => '',
            'hidden' => '',
        ]);
    }

    /**
     * Atualiza as informações do perfil do usuário.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        // 1. Validar os dados do formulário, incluindo o e-mail,
        // garantindo que ele seja único, exceto para o e-mail atual do usuário.
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(Auth::user()->id)],
            'password' => ['nullable', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        // 2. Atualizar as informações do usuário
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];

        // 3. Se uma nova senha foi fornecida, atualizá-la
        if ($request->filled('password')) {
            $user->password = Hash::make($validatedData['password']);
        }

        // 4. Salvar as alterações
        $user->save();

        return redirect()->route('profile.show', ['profile' => $user])->with('status', 'Perfil atualizado com sucesso!');
    }

    /**
     * Exclui a conta do usuário.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        // Obtém o usuário autenticado.
        $user = Auth::user();

        // Faz logout do usuário para encerrar a sessão.
        Auth::logout();

        // Exclui o usuário do banco de dados.
        $user->delete();

        // Invalida a sessão e regenera o token.
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redireciona para a página de login com uma mensagem de sucesso.
        return redirect('/login')->with('status', 'Sua conta foi excluída com sucesso.');
    }
}

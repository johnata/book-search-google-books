@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-xl w-full max-w-lg">
            <h2 class="text-3xl font-bold text-center mb-6 text-gray-900 dark:text-white">{{ $title }}</h2>

            @if (session('status'))
                <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-200 px-4 py-3 rounded-lg mb-4"
                    role="alert">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-200 px-4 py-3 rounded-lg mb-4"
                    role="alert">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="mt-8 space-y-6" method="POST" action="{{ route('profile.update', ['profile' => $user->id]) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 ">Nome</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                        autofocus {{ $disabled }}
                        class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all {{ $customClass }}">
                </div>

                <div class="mb-4">
                    <label for="email"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">E-mail</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                        {{ $disabled }}
                        class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all {{ $customClass }}">
                </div>

                @if ($editMode)
                    <div class="mt-8">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Mudar Senha (Opcional)</h3>
                        <div class="mb-4">
                            <label for="password"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nova
                                Senha</label>
                            <div class="relative">
                                <input type="password" id="password" name="password"
                                    class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                                <button type="button" id="togglePassword"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">
                                    <svg id="eye-open" class="h-5 w-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                    <svg id="eye-closed" class="h-5 w-5 hidden" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.027 10.027 0 0112 19c-4.478 0-8.268-2.943-9.542-7 1.274-4.057 5.064-7 9.542-7a10.028 10.028 0 011.875.175">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 12a2 2 0 114 0 2 2 0 01-4 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21L3 3">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="mb-6">
                            <label for="password_confirmation"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirmar Nova
                                Senha</label>
                            <div class="relative">
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                                <button type="button" id="togglePasswordConfirm"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">
                                    <svg id="eye-open-confirm" class="h-5 w-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                    <svg id="eye-closed-confirm" class="h-5 w-5 hidden" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.027 10.027 0 0112 19c-4.478 0-8.268-2.943-9.542-7 1.274-4.057 5.064-7 9.542-7a10.028 10.028 0 011.875.175">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 12a2 2 0 114 0 2 2 0 01-4 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21L3 3">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between space-x-4">
                        <button type="submit"
                            class="w-full bg-blue-600 text-white font-bold p-3 rounded-lg hover:bg-blue-700 transition-colors">
                            Salvar
                        </button>
                        <a href="{{ route('profile.show', ['profile' => $user->id]) }}"
                            class="w-full text-center bg-gray-600 text-white font-bold p-3 rounded-lg hover:bg-gray-700 transition-colors">
                            Cancelar
                        </a>
                    </div>
                @endif
            </form>

            @if (!$editMode)
                <!-- link editar -->
                <div class="text-center mt-6">
                    <a href="{{ route('profile.edit', ['profile' => $user->id]) }}"
                        class="text-blue-600 hover:underline dark:text-blue-400">
                        Editar Perfil
                    </a>
                </div>
                <div class="mt-12 border-t border-gray-200 dark:border-gray-700 pt-8">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Excluir Conta</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        Atenção: A exclusão da sua conta é uma ação permanente e não pode ser desfeita.
                    </p>
                    <form id="delete-account-form" method="POST"
                        action="{{ route('profile.destroy', ['profile' => $user->id]) }}) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full bg-red-600 text-white font-bold p-3 rounded-lg hover:bg-red-700 transition-colors">
                            Excluir Conta
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const password = document.getElementById('password');
            const eyeOpen = document.getElementById('eye-open');
            const eyeClosed = document.getElementById('eye-closed');

            if (togglePassword && password && eyeOpen && eyeClosed) {
                togglePassword.addEventListener('click', function() {
                    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                    password.setAttribute('type', type);

                    eyeOpen.classList.toggle('hidden');
                    eyeClosed.classList.toggle('hidden');
                });
            }

            const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
            const passwordConfirm = document.getElementById('password_confirmation');
            const eyeOpenConfirm = document.getElementById('eye-open-confirm');
            const eyeClosedConfirm = document.getElementById('eye-closed-confirm');

            if (togglePasswordConfirm && passwordConfirm && eyeOpenConfirm && eyeClosedConfirm) {
                togglePasswordConfirm.addEventListener('click', function() {
                    const type = passwordConfirm.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordConfirm.setAttribute('type', type);

                    eyeOpenConfirm.classList.toggle('hidden');
                    eyeClosedConfirm.classList.toggle('hidden');
                });
            }
        });
    </script>
@endpush

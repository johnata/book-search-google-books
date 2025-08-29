@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center min-h-screen pt-12 pb-12">
        <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-xl w-full max-w-lg">
            <h2 class="text-3xl font-bold text-center mb-6 text-gray-900 dark:text-white">Criar uma Conta</h2>

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

            <form class="mt-8 space-y-6" method="POST" action="{{ route('register.store') }}">
                @csrf
                <div class="mb-4">
                    <label for="name"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nome</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                        class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)] transition-all">
                </div>

                <div class="mb-4">
                    <label for="email"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">E-mail</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)] transition-all">
                </div>

                <div class="mb-4">
                    <label for="password"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Senha</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required
                            class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)] transition-all">
                        <button type="button" id="togglePassword"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">
                            <svg id="eye-open" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21L3 3"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="password_confirmation"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirmar Senha</label>
                    <div class="relative">
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)] transition-all">
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21L3 3">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>
                <button type="submit"
                    class="w-full bg-[var(--color-primary)] text-white font-bold p-3 rounded-lg hover:bg-[var(--color-primary-dark)] transition-colors">
                    Registrar
                </button>
            </form>
            <div class="mt-6 text-center text-sm">
                <p class="text-gray-600">
                    Já tem uma conta?
                    <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                        Efetue login aqui
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    @vite('resources/js/password-field.js')
@endpush

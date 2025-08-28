<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscador de Livros no Google Books</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ Vite::asset('resources/assets/img/favicon.ico') }}" type="image/x-icon">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-50 transition-colors duration-300">
    <nav
        class="relative bg-white dark:bg-gray-800 after:pointer-events-none after:absolute after:inset-x-0 after:bottom-0 after:h-px after:bg-black/10 dark:after:bg-white/10">
        <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
            <div class="relative flex h-16 items-center justify-between">
                <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                    <!-- Mobile menu button-->
                    <button type="button" command="--toggle" commandfor="mobile-menu"
                        class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-white focus:outline-2 focus:-outline-offset-1 focus:outline-indigo-500">
                        <span class="absolute -inset-0.5"></span>
                        <span class="sr-only">Open main menu</span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                            data-slot="icon" aria-hidden="true" class="size-6 in-aria-expanded:hidden">
                            <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                            data-slot="icon" aria-hidden="true" class="size-6 not-in-aria-expanded:hidden">
                            <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
                <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="flex shrink-0 items-center">
                        <img src="{{ Vite::asset('resources/assets/img/logo.png') }}" alt="Your Company"
                            class="h-8 w-auto" />
                    </div>
                    <div class="ml-3 flex items-center">
                        <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">
                            Buscador de Livros no Google Books
                        </h1>
                    </div>
                </div>
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                    <button type="button" id="theme-toggle"
                        class="relative flex items-center w-12 h-8 p-1 rounded-full cursor-pointer transition-colors duration-300 bg-gray-200 dark:bg-gray-700">
                        <div
                            class="absolute left-1 w-6 h-6 rounded-full shadow-md transform transition-transform duration-300 bg-white dark:translate-x-4 dark:bg-gray-900">
                        </div>
                        <div
                            class="absolute left-0 w-8 h-8 flex items-center justify-center text-gray-500 opacity-100 dark:opacity-0 transition-opacity duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div
                            class="absolute right-0 w-8 h-8 flex items-center justify-center text-gray-500 opacity-0 dark:opacity-100 transition-opacity duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        </div>
                    </button>


                    <!-- Profile dropdown -->
                    <el-dropdown class="relative ml-3">
                        <button
                            class="relative flex rounded-full focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                            <span class="absolute -inset-1.5"></span>
                            <span class="sr-only">Open user menu</span>
                            @guest
                                <span
                                    class="text-sm font-semibold text-gray-700 dark:text-gray-200 hover:text-indigo-500 transition-colors">Login/Registrar</span>
                            @endguest
                            @auth
                                <div
                                    class="size-8 rounded-full bg-gray-200 outline -outline-offset-1 outline-black/10 dark:bg-gray-800 dark:outline-white/10 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700 dark:text-gray-300"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            @endauth
                        </button>

                        <el-menu anchor="bottom end" popover
                            class="w-48 origin-top-right rounded-md bg-white py-1 shadow-lg outline outline-black/5 dark:bg-gray-800 dark:outline-white/10 transition transition-discrete [--anchor-gap:--spacing(2)] data-closed:scale-95 data-closed:transform data-closed:opacity-0 data-enter:duration-100 data-enter:ease-out data-leave:duration-75 data-leave:ease-in">
                            @guest
                                <a href="{{ route('login') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 focus:bg-gray-100 dark:text-gray-300 dark:focus:bg-white/5 focus:outline-hidden">Login</a>
                                <a href="{{ route('register.create') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 focus:bg-gray-100 dark:text-gray-300 dark:focus:bg-white/5 focus:outline-hidden">Registrar</a>
                            @endguest
                            @auth
                                <a href="{{ route('profile.edit') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 focus:bg-gray-100 dark:text-gray-300 dark:focus:bg-white/5 focus:outline-hidden">Perfil</a>
                                <form method="POST" action="{{ route('logout') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 focus:bg-gray-100 dark:text-gray-300 dark:focus:bg-white/5 focus:outline-hidden">
                                    @csrf
                                    <button type="submit"
                                        class="text-sm font-semibold text-gray-700 dark:text-gray-200 hover:text-red-500 transition-colors">Sair</button>
                                </form>
                            @endauth
                        </el-menu>
                    </el-dropdown>
                </div>
            </div>
        </div>
    </nav>

    <div class="w-full max-w-6xl mx-auto pt-5 p-6 duration-300">
        @yield('content')
    </div>
    @stack('scripts')
</body>

</html>

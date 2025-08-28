<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscador de Livros</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ Vite::asset('resources/assets/img/favicon.ico') }}" type="image/x-icon">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-50 transition-colors duration-300">

    <div class="hidden">
        <div class="bg-gray-900 bg-gray-800 bg-gray-700 bg-gray-600"></div>
        <div class="text-gray-200 text-gray-300 text-gray-400 text-gray-500 text-gray-600 text-red-900"></div>
        <div class="border-gray-600 border-red-700"></div>
    </div>

    <div class="fixed top-0 left-0 right-0 z-50 bg-white dark:bg-gray-800 shadow-lg p-6">
        <div class="max-w-6xl mx-auto flex flex-col sm:flex-row items-center justify-between">
            <header class="text-center sm:text-left mb-4 sm:mb-0">
                <div class="flex items-center justify-center">
                    <img src="{{ Vite::asset('resources/assets/img/logo.png') }}" alt="Logo"
                        class="inline w-12 h-12 mr-2">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Buscador de Livros
                    </h1>
                </div>
            </header>

            <form action="{{ route('books.search') }}" method="GET" class="w-full sm:w-auto">
                <div class="flex items-center space-x-2">
                    <select name="search_type"
                        class="p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)] transition-all bg-white dark:bg-gray-700 dark:text-gray-200">
                        <option value="all" {{ ($searchType ?? '') == 'all' ? 'selected' : '' }}>Todos os campos
                        </option>
                        <option value="intitle" {{ ($searchType ?? '') == 'intitle' ? 'selected' : '' }}>Título</option>
                        <option value="inauthor" {{ ($searchType ?? '') == 'inauthor' ? 'selected' : '' }}>Autor
                        </option>
                        <option value="subject" {{ ($searchType ?? '') == 'subject' ? 'selected' : '' }}>Assunto
                        </option>
                        <option value="inpublisher" {{ ($searchType ?? '') == 'inpublisher' ? 'selected' : '' }}>Editora
                        </option>
                        <option value="isbn" {{ ($searchType ?? '') == 'isbn' ? 'selected' : '' }}>ISBN</option>
                    </select>
                    <input type="text" name="query" placeholder="Digite seu termo de busca..."
                        class="flex-1 p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)] transition-all bg-white dark:bg-gray-700 dark:text-gray-200"
                        value="{{ $query ?? '' }}">
                    <button type="submit"
                        class="bg-[var(--color-primary)] text-white px-6 py-3 rounded-lg hover:bg-[var(--color-primary-dark)] transition-colors">
                        Buscar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="w-full max-w-6xl mx-auto pt-44 p-6 duration-300">
        @if (session('error'))
            <div class="bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-200 px-4 py-3 rounded-lg mb-6"
                role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        @isset($query)
            @php
                $filterMapping = [
                    'all' => 'Todos os campos',
                    'intitle' => 'Título',
                    'inauthor' => 'Autor',
                    'subject' => 'Assunto',
                    'inpublisher' => 'Editora',
                    'isbn' => 'ISBN',
                ];
                $currentFilter = $filterMapping[$searchType] ?? 'Desconhecido';
            @endphp
            <div class="mb-4 text-gray-600 dark:text-gray-400">
                <span>
                    Mostrando resultados para: <strong>"{{ $query }}"</strong>
                </span>
                <span class="ml-4">
                    Filtro: <strong>{{ $currentFilter }}</strong>
                </span>
            </div>
        @endisset

        @isset($books)
            <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200 mb-4">Resultados da Pesquisa</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($books as $book)
                    @php
                        $volumeInfo = $book['volumeInfo'];
                        $languageName =
                            [
                                'de' => 'Alemão',
                                'en' => 'Inglês',
                                'es' => 'Espanhol',
                                'fr' => 'Francês',
                                'pt-BR' => 'Português (Brasil)',
                                'pt' => 'Português',
                            ][$volumeInfo['language'] ?? ''] ?? 'Não especificado';
                    @endphp
                    <div
                        class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                        <div class="p-4 flex flex-col h-full">
                            <div class="flex justify-center items-start mb-4">
                                @if (isset($volumeInfo['imageLinks']['thumbnail']))
                                    <img src="{{ $volumeInfo['imageLinks']['thumbnail'] }}"
                                        alt="Capa do livro: {{ $volumeInfo['title'] ?? '' }}"
                                        class="h-48 object-contain rounded">
                                @else
                                    <div
                                        class="h-48 w-36 flex items-center justify-center bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 text-center rounded">
                                        Capa não<br>disponível
                                    </div>
                                @endif
                            </div>

                            <h3 class="font-bold text-lg text-gray-800 dark:text-gray-200 mb-1 leading-tight">
                                {{ $volumeInfo['title'] ?? 'Título não disponível' }}
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">
                                <strong>Autor(es):</strong> {{ implode(', ', $volumeInfo['authors'] ?? ['Desconhecido']) }}
                            </p>

                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                @if (isset($volumeInfo['publisher']))
                                    <p><strong>Editora:</strong> {{ $volumeInfo['publisher'] }}</p>
                                @endif
                                @if (isset($volumeInfo['publishedDate']))
                                    <p><strong>Publicação:</strong> {{ $volumeInfo['publishedDate'] }}</p>
                                @endif
                                @if (isset($volumeInfo['categories']))
                                    <p><strong>Categoria:</strong> {{ implode(', ', $volumeInfo['categories']) }}</p>
                                @endif
                                <p><strong>Idioma:</strong> {{ $languageName }}</p>
                            </div>

                            @if (isset($volumeInfo['description']))
                                <p class="text-sm text-gray-700 dark:text-gray-300 mb-4 overflow-hidden text-ellipsis h-16">
                                    {{ substr($volumeInfo['description'], 0, 150) }}...
                                </p>
                            @endif

                            <div class="mt-auto">
                                @if (isset($volumeInfo['averageRating']) && $volumeInfo['averageRating'] > 0)
                                    <div class="flex items-center text-yellow-500 mb-2">
                                        <span>
                                            @for ($i = 0; $i < round($volumeInfo['averageRating']); $i++)
                                                &#9733;
                                            @endfor
                                            @for ($i = 0; $i < 5 - round($volumeInfo['averageRating']); $i++)
                                                &#9734;
                                            @endfor
                                        </span>
                                        <span class="ml-2 text-gray-600 dark:text-gray-400 text-sm">
                                            ({{ $volumeInfo['ratingsCount'] ?? 0 }} avaliações)
                                        </span>
                                    </div>
                                @endif

                                <a href="{{ $volumeInfo['previewLink'] ?? '#' }}" target="_blank"
                                    class="block mt-auto text-center bg-[var(--color-primary)] text-white py-2 rounded-lg hover:bg-[var(--color-primary-dark)] transition-colors">
                                    Ver mais detalhes
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-xl text-gray-500 dark:text-gray-400">
                            Nenhum livro encontrado para "{{ $query }}". Tente outro termo de busca.
                        </p>
                    </div>
                @endforelse
            </div>

            @isset($totalItems)
                @php
                    $totalPages = ceil($totalItems / 20);
                    $prevPage = $currentPage - 1;
                    $nextPage = $currentPage + 1;
                @endphp
                @if ($totalPages > 1)
                    <div class="flex justify-center mt-8 space-x-2">
                        <a href="{{ route('books.search', ['query' => $query, 'search_type' => $searchType, 'page' => $prevPage]) }}"
                            class="px-4 py-2 rounded-lg @if ($currentPage <= 1) bg-gray-200 text-gray-400 cursor-not-allowed @else bg-[var(--color-primary)] text-white hover:bg-[var(--color-primary-dark)] @endif"
                            @if ($currentPage <= 1) aria-disabled="true" @endif>
                            Anterior
                        </a>
                        <span class="px-4 py-2 text-gray-700 dark:text-gray-200">Página {{ $currentPage }} de
                            {{ $totalPages }}</span>
                        <a href="{{ route('books.search', ['query' => $query, 'search_type' => $searchType, 'page' => $nextPage]) }}"
                            class="px-4 py-2 rounded-lg @if ($currentPage >= $totalPages) bg-gray-200 text-gray-400 cursor-not-allowed @else bg-[var(--color-primary)] text-white hover:bg-[var(--color-primary-dark)] @endif"
                            @if ($currentPage >= $totalPages) aria-disabled="true" @endif>
                            Próxima
                        </a>
                    </div>
                @endif
            @endisset
        @endisset
    </div>
</body>

</html>

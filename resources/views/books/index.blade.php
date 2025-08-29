@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-xl w-full">
            @if (session('error'))
                <div class="bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-200 px-4 py-3 rounded-lg mb-6"
                    role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <form action="{{ route('books.search') }}" method="GET" class="w-full">
                <div class="flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 sm:space-x-2">
                    <select name="search_type"
                        class="w-full sm:w-auto p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)] transition-all bg-white dark:bg-gray-700 dark:text-gray-200">
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
                        class="w-full flex-1 p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)] transition-all bg-white dark:bg-gray-700 dark:text-gray-200"
                        value="{{ $query ?? '' }}">
                    <button type="submit"
                        class="w-full sm:w-auto bg-[var(--color-primary)] text-white px-6 py-3 rounded-lg hover:bg-[var(--color-primary-dark)] transition-colors">
                        Buscar
                    </button>
                </div>
            </form>

            @isset($query)
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
                        <div
                            class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                            <div class="p-4 flex flex-col h-full">
                                <div class="flex justify-center items-start mb-4">
                                    @if (isset($book['volumeInfo']['imageLinks']['thumbnail']))
                                        <img src="{{ $book['volumeInfo']['imageLinks']['thumbnail'] }}"
                                            alt="Capa do livro: {{ $book['volumeInfo']['title'] ?? '' }}"
                                            class="h-48 object-contain rounded">
                                    @else
                                        <div
                                            class="h-48 w-36 flex items-center justify-center bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 text-center rounded">
                                            Capa não<br>disponível
                                        </div>
                                    @endif
                                </div>

                                <h3 class="font-bold text-lg text-gray-800 dark:text-gray-200 mb-1 leading-tight">
                                    {{ $book['volumeInfo']['title'] ?? 'Título não disponível' }}
                                </h3>
                                <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">
                                    @if (isset($book['volumeInfo']['subtitle']))
                                        <div><strong>Sub-título:</strong>
                                            {{ substr($book['volumeInfo']['subtitle'], 0, 30) }}...
                                        </div>
                                    @endif
                                    <div><strong>Autor(es):</strong>
                                        {{ implode(', ', $book['volumeInfo']['authors'] ?? ['Desconhecido']) }}
                                    </div>
                                    @if (isset($book['volumeInfo']['pageCount']))
                                        <div><strong>Número de páginas:</strong> {{ $book['volumeInfo']['pageCount'] }}</div>
                                    @endif
                                    <div><strong>ISBN:</strong>
                                        {{ $book['volumeInfo']['isbn'] ?? '' }}
                                    </div>
                                    @if (isset($book['volumeInfo']['publisher']))
                                        <div><strong>Editora:</strong> {{ $book['volumeInfo']['publisher'] }}</div>
                                    @endif
                                    @if (isset($book['volumeInfo']['publishedDate']))
                                        <div><strong>Publicação:</strong> {{ $book['volumeInfo']['publishedDate'] }}</div>
                                    @endif
                                    @if (isset($book['volumeInfo']['categories']))
                                        <div><strong>Categoria:</strong> {{ implode(', ', $book['volumeInfo']['categories']) }}
                                        </div>
                                    @endif
                                    <div><strong>Idioma:</strong> {{ $book['volumeInfo']['languageName'] }}</div>
                                    @if (isset($book['volumeInfo']['description']))
                                        <div><strong>Descrição:</strong>
                                            {{ substr($book['volumeInfo']['description'], 0, 150) }}...
                                        </div>
                                    @endif
                                </div>

                                <div class="mt-auto">
                                    @if (isset($book['volumeInfo']['averageRating']) && $book['volumeInfo']['averageRating'] > 0)
                                        <div class="flex items-center text-yellow-500 mb-2">
                                            <span>
                                                @for ($i = 0; $i < round($book['volumeInfo']['averageRating']); $i++)
                                                    &#9733;
                                                @endfor
                                                @for ($i = 0; $i < 5 - round($book['volumeInfo']['averageRating']); $i++)
                                                    &#9734;
                                                @endfor
                                            </span>
                                            <span class="ml-2 text-gray-600 dark:text-gray-400 text-sm">
                                                ({{ $book['volumeInfo']['ratingsCount'] ?? 0 }} avaliações)
                                            </span>
                                        </div>
                                    @endif

                                    <a href="{{ $book['volumeInfo']['previewLink'] ?? '#' }}" target="_blank"
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
    </div>
@endsection

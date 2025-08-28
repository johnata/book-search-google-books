<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Locale;

class BookController extends Controller
{
    protected $filterMapping = [
        'all' => 'Todos os campos',
        'intitle' => 'Título',
        'inauthor' => 'Autor',
        'subject' => 'Assunto',
        'inpublisher' => 'Editora',
        'isbn' => 'ISBN',
    ];

    public function index()
    {
        return view('books.index');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $searchType = $request->input('search_type');
        $maxResults = env('GOOGLE_BOOKS_MAX_RESULTS', 20); // Define o número de resultados por página
        $currentPage = (int) $request->input('page', 1); // Pega a página atual, padrão 1
        $startIndex = ($currentPage - 1) * $maxResults; // Calcula o índice de início
        $filterMapping = $this->filterMapping;
        $currentFilter = $filterMapping[$searchType] ?? 'Desconhecido';

        if (empty($query)) {
            return view('books.index', ['books' => null, 'query' => null, 'totalItems' => 0]);
        }

        if ($searchType == 'all') {
            $q = $query;
        } else {
            $q = $searchType . ':' . $query;
        }

        try {
            $response = Http::get('https://www.googleapis.com/books/v1/volumes', [
                'q' => $q,
                'maxResults' => $maxResults,
                'startIndex' => $startIndex,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $books = $data['items'] ?? [];
                $totalItems = $data['totalItems'] ?? 0;

                // Adiciona o nome do idioma para cada livro (Princípio de MVC - Separando responsabilidades)
                $books = collect($books)->map(function ($book) {
                    $book['volumeInfo']['languageName'] = $this->getLanguageName($book['volumeInfo']['language'] ?? '');
                    return $book;
                });

                return view('books.index', compact('filterMapping', 'currentFilter', 'books', 'query', 'totalItems', 'currentPage', 'searchType'));
            } else {
                return back()->with('error', 'Erro ao conectar com a API de livros. Tente novamente.');
            }

        } catch (\Exception $e) {
            return back()->with('error', 'Ocorreu um erro na busca: ' . $e->getMessage());
        }
    }

    /**
     * Traduz o código do idioma para o nome completo.
     *
     * @param string $locale O código do idioma (ex: 'en', 'pt-BR').
     * @return string O nome do idioma.
     */
    protected function getLanguageName(string $locale): string
    {
        $name = Locale::getDisplayLanguage($locale, 'pt_BR');
        return ucfirst($name) ?: 'Não especificado';
    }
}

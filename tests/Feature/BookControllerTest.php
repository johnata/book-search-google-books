<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;


class BookControllerTest extends TestCase
{
    #[Test]
    public function it_returns_the_initial_view_for_the_index_page()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewIs('books.index');
    }

    #[Test]
    public function it_displays_an_error_when_no_query_is_provided()
    {
        $response = $this->get('/search?query=&search_type=all');
        $response->assertStatus(200);
        $response->assertViewIs('books.index');
        $response->assertViewHas('books', null);
    }

    #[Test]
    public function it_successfully_searches_for_books_and_displays_results()
    {
        // 1. Simula a resposta da API do Google Books
        Http::fake([
            'https://www.googleapis.com/books/v1/volumes*' => Http::response([
                'kind' => 'books#volumes',
                'totalItems' => 1,
                'items' => [
                    [
                        'volumeInfo' => [
                            'title' => 'The Lord of the Rings',
                            'language' => 'en',
                            'authors' => ['J.R.R. Tolkien'],
                        ],
                    ],
                ],
            ], 200),
        ]);

        // 2. Faz uma requisição para a rota de busca
        $response = $this->get('/search?query=Lord+of+the+Rings&search_type=intitle');

        // 3. Verifica a resposta da aplicação
        $response->assertStatus(200);
        $response->assertViewIs('books.index');
        $response->assertSee('The Lord of the Rings');
        $response->assertSee('J.R.R. Tolkien');
    }

    #[Test]
    public function it_handles_api_errors_and_redirects_with_an_error_message()
    {
        // 1. Simula uma resposta de erro da API
        Http::fake([
            'https://www.googleapis.com/books/v1/volumes*' => Http::response(null, 500),
        ]);

        // 2. Faz a requisição de busca
        $response = $this->get('/search?query=test&search_type=all');

        // 3. Verifica se a aplicação redireciona e exibe a mensagem de erro
        $response->assertStatus(302); // Redirecionamento
        $response->assertSessionHas('error', 'Erro ao conectar com a API de livros. Tente novamente.');
    }

   #[Test]
    public function it_correctly_builds_the_query_for_a_specific_search_type()
    {
        // 1. Simula a resposta da API para qualquer requisição à URL base.
        Http::fake([
            'https://www.googleapis.com/books/v1/volumes*' => Http::response([
                'totalItems' => 1,
                'items' => [],
            ], 200),
        ]);

        // 2. Faz uma requisição para a rota de busca. Laravel vai URL-encode o 'query'
        $this->get('/search?query=J.R.R. Tolkien&search_type=inauthor');

        // 3. Afirma que uma requisição foi enviada com os parâmetros corretos.
        Http::assertSent(function ($request) {
            // Verifica a URL base
            $urlMatches = str_starts_with($request->url(), 'https://www.googleapis.com/books/v1/volumes');

            // Pega os parâmetros da query para uma verificação mais robusta
            $queryParams = $request->url();
            $queryParams = explode('?', $queryParams)[1] ?? '';
            parse_str($queryParams, $params);

            // Retorna true se todos os parâmetros estiverem corretos
            return $urlMatches
                && ($params['q'] ?? null) === 'inauthor:J.R.R. Tolkien'
                && ($params['maxResults'] ?? null) == env('GOOGLE_BOOKS_MAX_RESULTS', 20)
                && ($params['startIndex'] ?? null) == 0;
        });
    }
}

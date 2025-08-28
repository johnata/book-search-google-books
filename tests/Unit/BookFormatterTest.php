<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

/**
 * Teste de unidade para a classe BookFormatter,
 * que seria responsável por formatar dados de livros da API.
 * Este teste não faz nenhuma chamada real à API do Google Books.
 */
class BookFormatterTest extends TestCase
{
    /**
     * Verifica se o método de formatação retorna o título e o autor corretamente
     * de um objeto de dados simulado da API.
     */
    #[Test]
    public function it_can_format_book_data_correctly()
    {
        // 1. Arrange: Preparamos os dados de entrada (simulando a resposta da API)
        // e a instância da classe de formatação.
        $apiData = [
            'volumeInfo' => [
                'title' => 'O Senhor dos Anéis',
                'authors' => [
                    'J.R.R. Tolkien'
                ],
                'publisher' => 'HarperCollins',
                'publishedDate' => '1954',
                'description' => 'Um clássico da literatura de fantasia...',
                'imageLinks' => [
                    'thumbnail' => 'http://example.com/cover.jpg'
                ]
            ]
        ];

        $formatter = new BookFormatter();

        // 2. Act: Executamos o método de formatação com os dados simulados.
        $formattedData = $formatter->format($apiData);

        // 3. Assert: Verificamos se o resultado formatado é o esperado.
        // O teste verifica se os dados foram extraídos e formatados corretamente.
        $this->assertEquals('O Senhor dos Anéis', $formattedData['title']);
        $this->assertEquals('J.R.R. Tolkien', $formattedData['author']);
        $this->assertEquals('1954', $formattedData['published_date']);
        $this->assertArrayHasKey('image_url', $formattedData);
    }

    /**
     * Verifica se o método lida corretamente com dados ausentes ou inválidos.
     * Neste caso, simulamos uma resposta da API sem o autor.
     */
    #[Test]
    public function it_handles_missing_author_gracefully()
    {
        // Arrange: Dados da API sem a chave 'authors'.
        $apiData = [
            'volumeInfo' => [
                'title' => 'O Senhor dos Anéis',
                'publisher' => 'HarperCollins'
                // 'authors' está ausente aqui intencionalmente
            ]
        ];

        $formatter = new BookFormatter();

        // Act
        $formattedData = $formatter->format($apiData);

        // Assert: Esperamos que o autor seja 'Autor desconhecido'
        $this->assertEquals('Autor desconhecido', $formattedData['author']);
    }
}

/**
 * Esta é uma classe de exemplo que você usaria no seu projeto,
 * como um serviço ou classe de utilidade.
 * Exemplo de uso: $formatter = new BookFormatter(); $data = $formatter->format($apiResponse);
 */
class BookFormatter
{
    /**
     * Formata os dados de um livro retornados da API do Google Books.
     *
     * @param array $bookData O objeto de dados do livro da API.
     * @return array Um array formatado com as informações do livro.
     */
    public function format(array $bookData): array
    {
        $volumeInfo = $bookData['volumeInfo'] ?? [];

        return [
            'title' => $volumeInfo['title'] ?? 'Título desconhecido',
            'author' => $volumeInfo['authors'][0] ?? 'Autor desconhecido',
            'published_date' => $volumeInfo['publishedDate'] ?? 'Data desconhecida',
            'description' => $volumeInfo['description'] ?? 'Sem descrição.',
            'image_url' => $volumeInfo['imageLinks']['thumbnail'] ?? null,
        ];
    }
}

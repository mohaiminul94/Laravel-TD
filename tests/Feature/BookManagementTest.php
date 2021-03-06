<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class BookManagementTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_added_to_the_library()
    {
        $this->withoutExceptionHandling();
        $response= $this->post('book', [
           'title'    => 'Cool Book Name',
           'author'   => 'Victor'
        ]);
        $book= Book::first();
        $this->assertCount(1, Book::all());
        $response->assertRedirect('book/'. $book->id);
    }

    /** @test */
    public function book_title_is_required()
    {
        $response= $this->post('book', [
            'title'    => '',
            'author'   => 'Victor'
        ]);
        $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_book_can_be_updated()
    {
        $this->withoutExceptionHandling();
        $this->post('book', [
            'title'    => 'Cool Book Name',
            'author'   => 'Victor'
        ]);
        $book= Book::first();
        $response= $this->put('book/'.$book->id, [
            'title'    => 'New Title',
            'author'   => 'New Author'
        ]);
        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals('New Author', Book::first()->author);
        $response->assertRedirect('book/'. $book->id);
    }

    /** @test */
    public function a_book_can_be_deleted()
    {
        $this->withoutExceptionHandling();
        $this->post('book', [
            'title'    => 'Cool Book Name',
            'author'   => 'Victor'
        ]);
        $book= Book::first();
        $this->assertCount(1, Book::all());
        $response= $this->delete('book/'.$book->id);
        $this->assertCount(0, Book::all());
        $response->assertRedirect('book');
    }

}

<?php 
namespace App\Controllers;

use \App\Models\Book;
use \App\Helpers\Config;
use \App\Helpers\Database;
use \Firebase\JWT\JWT;

class BookStoreController extends Controller
{   
    public function all()
    {

        $books = $this->database->query(
            "SELECT books.id, books.title, books.author, IFNULL(ROUND(AVG(ratings.rating)), 0) as rating FROM books LEFT JOIN ratings on books.id = ratings.book_id GROUP BY books.id"
        )->fetchAll();

        return $this->response->withJson(['status' => 'success', 'data' => $books]);
    }

    /**
     * This method Stores book
     * JWT authorization is required in other to identy the author
     * 
     * @param [type] $req
     * @param [type] $res
     * @return void
     */
    public function store($req, $res)
    {
        if (empty($req->getParam('title')) ||empty($req->getParam('desc'))) {
            return $this->response->withJson(['status' => 'error', 'message' =>'All fields are required'])->withStatus(422);
        }

        $decoded = $req->getAttribute('decoded_token_data');

        $store= Book::create([
            'author' => $decoded->id,
            'title' => $req->getParam('title'),
            'desc' => $req->getParam('desc')
        ]);

        return $res->withStatus(200)->withJson($store);
    }

    /**
     * This method fetches a single book
     * No Authorization requried
     *
     * @param [type] $req
     * @param [type] $res
     * @param array $args
     * @return void
     */
    public function single($req, $res, array $args)
    {
        $stmt = $this->database->prepare(
            "SELECT books.id, books.title, books.author, IFNULL(ROUND(AVG(ratings.rating)), 0) as rating FROM books LEFT JOIN ratings on books.id = ratings.book_id WHERE books.id = :id"
        );

        $stmt->execute([':id' => $args['id']]);

        $book = $stmt->fetchAll();
        
        return $res->withJson(['status' => 'success', 'data' => $book])
        ->withStatus(200);
    }
    
    /**
     * This method Updates a single book
     * JWT authorization is required in other to identy the author
     *
     * @param [type] $req
     * @param [type] $res
     * @param array $args
     * @return void
     */
    public function update($req, $res, array $args)
    {
        $id = $args['id'];
        
        $decoded = $req->getAttribute('decoded_token_data');

        $book = Book::find($id);

        if (! $book) {
            return $res->withJson(['status' => 'error', 'message' => 'Book not found']);
        }

        if ($decoded->id !== $book->author) {
            return $res->withJson(['status' => 'error', 'message' => 'Fobidden'])
            ->withStatus(402);
        }

        $book->fill($req->getParams());

        return $res->withJson(['status' => 'success'])
        ->withStatus(200);
    }

    /**
     * This method deletes a singlr book from the bookstore
     * JWT authorization is required in other to identy the author
     *
     * @param [type] $req
     * @param [type] $res
     * @param array $args
     * @return void
     */
    public function delete($req, $res, array $args)
    {
        $id = $args['id'];

        $decoded = $req->getAttribute('decoded_token_data');

        try {

            $book = Book::find($id);

        } catch(\Exception $e) {

            return $res->withStatus(500);
        }

        if (! $book) {

            return $res->withJson(['status' => 'error', 'message' => 'Book not found'])
            ->withStatus(404);
        }
    
        if ($decoded->id !== $book->author) {

            return $res->withJson(['status' => 'error', 'message' => 'Fobidden'])
            ->withStatus(403);
        }

        try {

            Book::destroy($id);

        } catch(\Exception $e) {

            return $res->withStatus(500);
        }
        return $res->withJson(['status' => 'success', 'message' => 'book deleted'])
        ->withStatus(200);
    }
}
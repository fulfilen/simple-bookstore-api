<?php
namespace App\Controllers;

use \App\Models\Rating;
use \App\Models\Book;
use \Firebase\JWT\JWT;

class RatingController extends Controller
{
    public function rateBook($request, $response, array $args)
    {
        $book_id  = $args['book_id'];
        $rating  = $args['rating'];

        if (empty($book_id) ||empty($rating)) {
            return $this->response->withJson(['status' => 'error', 'message' =>'All fields are required'])->withStatus(422);
        }

        if (! in_array($rating, range(1,5))) {
            return $this->response->withJson(['status' => 'error', 'message' => 'Inavalid Input'])
            ->withStatus(422);
        }

        if (! Book::find($book_id)) {
            return $this->response->withJson(['status' => 'error', 'message' => 'Inavalid Book'])
            ->withStatus(422);
        }

        $decoded = $request->getAttribute('decoded_token_data');

        $rate = Rating::create([
            'book_id' => $book_id,
            'rating'  => $rating,
            'user_id' => $decoded->id
        ]);

        return $this->response->withJson(['status' => 'success', 'message' => 'rating added']);
    
    }
}

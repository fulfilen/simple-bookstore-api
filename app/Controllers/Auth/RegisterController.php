<?php 
namespace App\Controllers\Auth;

use \App\Models\User;
use \Firebase\JWT\JWT;
use Respect\Validation\Validator as v;
use App\Controllers\Controller;

class RegisterController extends Controller
{   

    public function register($req, $res, array $args)
    {
        $validation = $this->validateRegisterRequest($req, $res);
        
        if ($validation->failed()) {
            return $res->withJson(['status' => 'error', 'message' => $validation->getErrors()])->withStatus(422);
        }

        try {

            User::create([
                'username' => $req->getParam('username'),
                'email'    => $req->getParam('email'),
                'password' => password_hash($req->getParam('password'), PASSWORD_DEFAULT)
            ]);

        } catch(Exception $e) {
            
           return $res->withStatus(500);
        }
        
        return $res->withJson(['status' => 'success', 'message' => 'Account created successfully'])
        ->withStatus(200);
    }

    public function validateRegisterRequest($req)
    {
        return $this->validator->validate($req, [
            'email' => v::notEmpty()->noWhiteSpace()->email()->emailAvailable(),
            'username' => v::notEmpty()->noWhiteSpace()->alpha()->usernameAvailable(),
            'password' => v::notEmpty()->noWhiteSpace(),
        ]);
    }
}
<?php 
namespace App\Controllers\Auth;

use \App\Models\User;
use \Firebase\JWT\JWT;
use Respect\Validation\Validator as v;
use App\Controllers\Controller;

class LoginController extends Controller
{   
    public function login($req, $res)
    {
        $validation = $this->validateLoginRequest($req, $res);

        if ($validation->failed()) {
            return $res->withJson(['status' => 'error', 'message' => $validation->getErrors()])->withStatus(422);
        }

        $user = User::where('email', $req->getParam('email'))->first();

        if(!$user) {
            return $this->response->withJson(['status' => 'error', 'message' => 'user not found'])->withStatus(422);
        }

        if (!password_verify($req->getParam('password'), $user->password)) {
            return $res->withJson(['status' => 'error', 'message' => 'These credentials do not match our records.'])
            ->withStatus(422);  
        }

        //importing settings
        $settings = require __DIR__ . '/../../../app/settings.php';
        // encode & generate token using JWT
        $token = JWT::encode([
            'id' => $user->id, 
            'email' => $user->email
        ], 
        $settings['settings']['jwt']['secret'], "HS256"
        );

        return $this->response->withJson(['status' => 'success', 'data' => ['token' => $token]])->withStatus(200);
    }

    public function validateLoginRequest($req, $res)
    {
        return $this->validator->validate($req, [
            'email' => v::notEmpty()->noWhitespace()->email(),
            'password' => v::notEmpty()->noWhitespace(),
        ]);
        
    }
}
<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);

$app->add(new \Slim\Middleware\JwtAuthentication([

    "path"        => "/api", /* or ["/api", "/admin"] */
    "passthrough" => ["/admin/ping", "/api/ratin"],
    "attribute"   => $settings['settings']['jwt']['attribute'],
    "secret"      => $settings['settings']['jwt']['secret'],
    'secure'      => false,
    "algorithm"   => ["HS256"],
    "error"       => function ($req, $res, $args) {
    
        $data["status"] = "error";
        $data["message"] = $args["message"];
        return $res
            ->withHeader("Content-Type", "application/json")
            ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    }
]));

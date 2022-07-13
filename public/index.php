<?php
setlocale(LC_ALL, "fr_FR");
date_default_timezone_set('Europe/Paris');
setlocale(LC_TIME, 'fr_FR.utf8','fra');

use App\Kernel;
// use Symfony\Component\Dotenv\Dotenv;
// use Symfony\Component\HttpFoundation\Request;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';
// (new Dotenv())->bootEnv(dirname(__DIR__).'/.env');

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};

// return function (array $context) {
//         $request        = Request::createFromGlobals();
//         $request->attributes->set("app", json_decode(file_get_contents(__DIR__ . "/../config/.app.json", "r"), true));
//         $kernel         = new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
//         $response       = $kernel->handle($request);
//         $response->send();
//         $kernel->terminate($request, $response); 

//         return $kernel;
// };
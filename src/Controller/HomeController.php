<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Model\HomeModel;
use App\Lib;

class HomeController extends AbstractController
{

        #[Route('/bye/{name}', 
                methods:        ['GET'], 
                name:           'bye', 
                defaults:       ['name' => "World"])]
        #[Route('/hello/{name}',
                name:           'hello',
                methods:        ['GET'], 
                defaults:       ['name' => "World"])]
        #[Route('/', 
                name:           'home',
                methods:        ['GET'])]
        public function index(Request $request): Response
        {
                
                // GET
                $query                  = $request->query->all();

                // Request Attributs (route name, route param...)
                $attributes             = $request->attributes->all();

                // Add .app.json
                $attributes['app']      = json_decode(file_get_contents(__DIR__ . "/../../config/.app.json", "r"), true);

                // Add Keys
                $keys                   = $attributes['app']['WEB_API'];
                unset($attributes['app']['WEB_API']);

                // Simple Data
                $data   = [
                                '_route'        => $attributes['_route'],
                                'app'           => $attributes['app'],
                                '_IP'           => $request->getClientIp(),
                                '_usrAgent'     => $request->headers->get('User-Agent')
                        ];

                // Data Calendar, météo...
                $model  = new HomeModel($attributes, $query, $keys);

                // Create hello message with model and set _route name at home /burp!
                if ($attributes['_route'] == 'hello' || $attributes['_route'] == 'bye') {
                        $data['_route'] = 'home';
                }

                // Merge Tab data with model
                $data   = array_merge($data, $model->getInfo());

                // Clean
                unset($keys);

                // Send data at template
                return  $this->render($data['_route'] . '/index.html.twig', $data);

        }


        #[Route('/bg', 
                name: 'bg',
                methods         : ['GET'])]
        public function bg(Request $request): JsonResponse
        {
                return  new JsonResponse(['bg'  =>  HomeModel::myBackgroundPost($request->query->all())]);
        }

}

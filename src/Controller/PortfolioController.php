<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;      //
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;   //

use App\Model\PortfolioModel;
use App\Lib;    //

class PortfolioController extends AbstractController
{

        #[Route('/portfolio', 
                methods: ['GET'], 
                name: 'portfolio')]
        public function index(Request $request, Environment $twig):Response
        {

                // GET
                $query                  = $request->query->all();
                
                // Request Attributs (route name, route param...)
                $attributes             = $request->attributes->all();

                // Add .app.json
                $attributes['app']      = json_decode(file_get_contents(__DIR__ . "/../../config/.app.json", "r"), true);

                // Delete Keys
                unset($attributes['app']['WEB_API']);

                // Simple Data
                $data   = [
                        '_route'        => $attributes['_route'],
                        'app'           => $attributes['app']
                ];

                // Add Github Portfolio
                $model  = new PortfolioModel($attributes);

                // Merge Tab data with model
                $data   = array_merge($data, $model->getInfo());

                return  $this->render($attributes['_route'] . '/index.html.twig', $data);

        }

}

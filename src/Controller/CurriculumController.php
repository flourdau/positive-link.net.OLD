<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;   //

use App\Lib;    //
use App\Model\CurriculumModel;

class CurriculumController extends AbstractController
{
    
        #[Route('/curriculum',
                methods: ['GET'],
                name: 'curriculum')]
        public function index(Request $request): Response
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

                $model  = new CurriculumModel($attributes);

                // Merge Tab data with model
                $data   = array_merge($data, $model->getInfo());

                // send data at template
                return  $this->render($data['_route'] . '/index.html.twig', $data);

        }

}

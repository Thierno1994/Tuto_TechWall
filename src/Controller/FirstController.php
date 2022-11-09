<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{
    #[Route('/order/{maVar}', name: 'test.order.route')]
    public function testOrderRoute($maVar){
        return new Response(content: "<html><body>$maVar</body></html>");
    }

    #[Route('/template', name: 'template')]
    public function template(){
        return $this->render('template.html.twig');
    }

    #[Route('/first', name: 'first')]
    public function index(): Response
    {
        /*die("Je suis la requête /first ");*/
        
        return $this->render('first/index.html.twig', [
            'controller_name' => 'FirstController',
            'firstname' => 'Sow',
            'name' => 'Thierno Oumar'
        ]);
        /*
        return new Response (
            content:"<head>
                            <title>Ma prémière page</title>
                            <body>
                                <h1>Hello Techwall Symfony 6</h1>
                            </body>
                        </head>"
        );
        */
        
    }

    //#[Route('/sayHello/{name}/{firstname}', name: 'say.hello')]
    public function sayHello(Request $request, $name, $firstname): Response
    {
        /*$rand = rand(0,10);
        echo $rand;
        if($rand % 2 == 0)//Une fois sur 2 il va executer le code
        {
            return $this->redirectToRoute(route:'first');
        }
        return $this->forward(controller:'App\Controller\FirstController::index');*/

        //dd($request);
        return $this->render('first/hello.html.twig', [
            'nom' => $name, 
            'prenom' => $firstname
        ]);
    }

    #[Route(
        '/multi/{entier1<\d+>}/{entier2<\d+>}', 
        name: 'multiplication'/**,
        requirements: ['entier1' => '/d+','entier2' => '/d+']*/
    )]
    public function multiplication($entier1, $entier2){
        $resultat = $entier1 * $entier2;
        return new Response(content:"<h1>$resultat</h1>");
    }
}

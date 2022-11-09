<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TabController extends AbstractController
{
    #[Route('/tab/{nb</d+>?5}', name: 'tab')]
    public function index($nb): Response
    {
        $notes = [];
        for($i = 0 ; $i<$nb ; $i++){
            $notes[] = rand(0,20);
        }
        return $this->render('tab/index.html.twig', [
            'notes' => $notes,
        ]);
    }

    #[Route('/tab/users', name: 'tab.users')]
    public function users(): Response
    {
        $users = [
            ['firstname'=>'Souleymane', 'name'=>'Sow', 'age'=>29],
            ['firstname'=>'Thierno Oumar', 'name'=>'Sow', 'age'=>28],
            ['firstname'=>'Abdoul Aziz', 'name'=>'Sow', 'age'=>24],
            ['firstname'=>'Amadou Tahirou', 'name'=>'Sow', 'age'=>21],
            ['firstname'=>'Mamadou Saliou', 'name'=>'Sow', 'age'=>19],
            ['firstname'=>'Hadja Mariama', 'name'=>'Sow', 'age'=>14],
            ['firstname'=>'Deen', 'name'=>'Sow', 'age'=>11],
            ['firstname'=>'Aladji', 'name'=>'Sow', 'age'=>1]
        ];
        return $this->render('tab/users.html.twig', [
            'users' => $users
        ]);
    }
}

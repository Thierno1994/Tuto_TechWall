<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Form\PersonneType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('personne')]
class PersonneController extends AbstractController
{
    #[Route('/', name: 'personne.list')]
    public function index(ManagerRegistry $doctrine): Response {
        $repository = $doctrine->getRepository(Personne::class);
        $personnes = $repository->findAll();
        return $this->render('personne/index.html.twig',[
            'personnes' => $personnes
        ]);
    }
    
    #[Route('/alls/age/{ageMin}/{ageMax}', name: 'personne.list.age')]
    public function personneByAge(ManagerRegistry $doctrine, $ageMin, $ageMax): Response {
        $repository = $doctrine->getRepository(Personne::class);
        $personnes = $repository->findPersonneByAgeInterval($ageMin, $ageMax);
        return $this->render('personne/index.html.twig',[
            'personnes' => $personnes
        ]);
    }
    
    #[Route('/stats/age/{ageMin}/{ageMax}', name: 'personne.stats.age')]
    public function statsPersonneByAge(ManagerRegistry $doctrine, $ageMin, $ageMax): Response {
        $repository = $doctrine->getRepository(Personne::class);
        $stats = $repository->statsPersonneByAgeInterval($ageMin, $ageMax);
        //dd($stats);
        return $this->render('personne/stats.html.twig',[
            'stats' => $stats[0], 
            'ageMin' => $ageMin, 
            'ageMax' => $ageMax
        ]);
    }
    
    #[Route('/alls/{page?1}/{nbre?12}', name: 'personne.list.alls')]
    public function indexAlls(ManagerRegistry $doctrine, $page, $nbre): Response {
        $repository = $doctrine->getRepository(Personne::class);
        $personnes = $repository->findBy([], ['id' => 'ASC'], limit:$nbre, offset:($page - 1) * $nbre);
        $nbrePersonne = $repository->count([]);
        $nbrePage = $nbrePersonne % $nbre == 0 ? $nbrePersonne / $nbre : ceil($nbrePersonne / $nbre);
        //$nbrePage = ceil($nbrePersonne / $nbre);
        //dd($nbrePage);
        return $this->render('personne/index.html.twig',[
            'personnes' => $personnes,
            'isPaginated' => true,
            'nbrePage' => $nbrePage,
            'page' => $page,
            'nbre' => $nbre
        ]);
    }
    
    #[Route('/{id<\d+>}', name: 'personne.detail')]
    public function detail(/*ManagerRegistry $doctrine,*/ Personne $personne = null /*$id*/): Response {
        /*$repository = $doctrine->getRepository(Personne::class);
        $personne = $repository->find($id);*/
        if(!$personne){
            $this->addFlash(type:'error', message:"La personne n'existe pas");
            return $this->redirectToRoute(route:'personne.list');
        }
        return $this->render('personne/detail.html.twig',[
            'personne' => $personne
        ]);
    }

    #[Route('/add', name: 'personne.add')]
    public function addPersonne(ManagerRegistry $doctrine, Request $request): Response
    {
        $personne = new Personne();
        //$personne est l'image de notre formulaire
        $form = $this->createForm(PersonneType::class, $personne);
        $form->remove('createdAt');
        $form->remove('updatedAt');
        
        
        //$form->setData('profile', NumberType::class);
        $form->handleRequest($request);
        
        if($form->isSubmitted()){
            $personne = $form->getData();
            dd($personne);
            $manager = $doctrine->getManager();
            $manager->persist($personne);
            $manager->flush();
            
            $this->addFlash(type:'succes', message: $personne->getName(). "à ete ajouté avec succes");
            return $this->redirectToRoute('/alls');
        }
        else{
            return $this->render('personne/add-personne.html.twig', [
                'form_formulaire' => $form->createView()
            ]);
        }
            
    }

    #[Route('/delete/{id}', name:'personne.delete')]
    public function deletePersonne(Personne $personne = null, ManagerRegistry $doctrine): RedirectResponse{
        //Si la personne existe => le supprimer et retourner un flash message de succes
        if($personne){
            $manager = $doctrine->getManager();
            //Ajoute la fonction de suppresion à la transaction
            $manager->remove($personne);
            //exécute la transaction
            $manager->flush();
            $this->addFlash(type:'success', message:'La personne à été suprimé avec succes');
        }else{
            //sinon retourner un flah message d'erreur
            $this->addFlash(type:'error', message:'Personne innexistante');
        }
        
        return $this->redirectToRoute(route:'personne.list.alls');
    }
    
    #[Route('/update/{id}/{firstname}/{name}/{age}', name:'personne.update')]
    public function updatePersonne(Personne $personne = null, ManagerRegistry $doctrine, $name, $firstname, $age): RedirectResponse{
        //Si la personne existe => mettre a jour la personne et retourner un flash message de succes
        if($personne){
            $personne->setName($name);
            $personne->setFirstname($firstname);
            $personne->setAge($age);
            $manager = $doctrine->getManager();
            //Ajoute la fonction de suppresion à la transaction
            $manager->persist($personne);
            //exécute la transaction
            $manager->flush();
            $this->addFlash(type:'success', message:'La personne à été mis à jour avec succes');
        }else{
            //sinon retourner un flah message d'erreur
            $this->addFlash(type:'error', message:'Personne innexistante');
        }
        
        return $this->redirectToRoute(route:'personne.list.alls');
    }

}

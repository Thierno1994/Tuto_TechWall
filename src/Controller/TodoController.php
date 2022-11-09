<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/todo')] 
/**
*Cette déclaration de route est préfixe c-a-d dès qu'on est dans ce controller
*de façon global on indique que cette route est là et pour que le routing fonctionne correctement
*il faudrait savoir que toute route qu'on ajoutera il accedera d'abourd à la route préfixe
*et concatenera les autres routes.
*/

class TodoController extends AbstractController
{
    #[Route('/', name: 'todo')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        //Affichez tableau de todo
        //si ma session n'existe pas l'initialiser
        if(!$session->has(name:'todos')) {
            $todo = [
                'achat' => 'acheter clé usb',
                'cours' => 'Finaliser mon cours',
                'correction' => 'Corriger mes examens'
            ];
            $session->set('todos', $todo);
            $this->addFlash('info', "La liste des todo viens d'être initialisée");
        }
        //Si j'ai mon tableau de todo dans ma session je ne fais que l'affichez
        
        return $this->render('todo/index.html.twig');
    }

    #[Route(
        '/add/{name?testName}/{content?testContent}', 
        name: 'todo.add'/**,
        defaults: ['name' => 'sf6', 'content' => 'techWall'] */
        )]
    public function addTodo(Request $request, $name, $content) :RedirectResponse{
        $session = $request->getSession();
        //Verifier si j'ai mon tableau todo dans la session
        if($session->has(name: 'todos')){
            //si oui
                //Verifier si on a deja un todo avec le meme nom
                $todos = $session->get(name: 'todos');
                if(isset($todos[$name])){
                    //si oui afficher erreur
                    $this->addFlash('error', "Le todo d'id $name existe déjà dans la liste");
                }
                else{
                    //sinon on l'ajoute et on affiche un message de succes
                    $todos[$name] = $content;
                    $this->addFlash('success', "Le todo d'id $name à été ajoutée avec succes");
                    $session->set('todos', $todos);
                }
        }
        else{
            //si non
            //Afficher une erreur et on va rediriger vers le controller index
            $this->addFlash('error', "La liste des todo n'est pas encore initialisée");
        }   
        return $this->redirectToRoute('todo');
    }

    #[Route('/update/{name}/{content}', name: 'todo.update')]
    public function updateTodo(Request $request, $name, $content) :RedirectResponse{
        $session = $request->getSession();
        //Verifier si j'ai mon tableau todo dans la session
        if($session->has(name: 'todos')){
            //si oui
                //Verifier si on a deja un todo avec le meme nom
                $todos = $session->get(name: 'todos');
                if(!isset($todos[$name])){
                    //si oui afficher erreur
                    $this->addFlash('error', "Le todo d'id $name n'existe pas dans la liste");
                }
                else{
                    //sinon on l'ajoute et on affiche un message de succes
                    $todos[$name] = $content;
                    $this->addFlash('success', "Le todo d'id $name à été modifié avec succes");
                    $session->set('todos', $todos);
                }
        }
        else{
            //si non
            //Afficher une erreur et on va rediriger vers le controller index
            $this->addFlash('error', "La liste des todo n'est pas encore initialisée");
        }   
        return $this->redirectToRoute('todo');
    }

    #[Route('/delete/{name}', name: 'todo.delete')]
    public function deleteTodo(Request $request, $name) :RedirectResponse{
        $session = $request->getSession();
        //Verifier si j'ai mon tableau todo dans la session
        if($session->has(name: 'todos')){
            //si oui
                //Verifier si on a deja un todo avec le meme nom
                $todos = $session->get(name: 'todos');
                if(!isset($todos[$name])){
                    //si oui afficher erreur
                    $this->addFlash('error', "Le todo d'id $name n'existe pas dans la liste");
                }
                else{
                    //sinon on l'ajoute et on affiche un message de succes
                    unset($todos[$name]);
                    $session->set('todos', $todos);
                    $this->addFlash('success', "Le todo d'id $name à été supprimé avec succes");
                }
        }
        else{
            //si non
            //Afficher une erreur et on va rediriger vers le controller index
            $this->addFlash('error', "La liste des todo n'est pas encore initialisée");
        }   
        return $this->redirectToRoute('todo');
    }

    #[Route('/reset', name: 'todo.reset')]
    public function resetTodo(Request $request) :RedirectResponse{
        $session = $request->getSession();
        $session->remove(name:"todos");
        return $this->redirectToRoute('todo');
    }
    
}

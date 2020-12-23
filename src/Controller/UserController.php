<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Subscription;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mon-espace-client")
 */
class UserController extends AbstractController
{
    /**
     * @Route("", name="user_home", methods={"GET","POST"})
     */
    public function index(UserRepository $userRepository, Request $request): Response
    {
        // Récupérer l'utilisateur connecté
        $user = $this->getUser(); 

        // Créer un formulaire lié à ce utilisateur
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

        }

        return $this->render('espace-client/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
    /**
     * @Route("/mes-souscriptions", name="user_subscriptions", methods={"GET","POST"})
     */

    public function indexSubscriptions()
    {
        $user = $this->getUser();
        $subscriptions = $user->getSubscriptions();
        
        return $this->render('espace-client/subscription_index.html.twig', [
            'subscriptions' => $this->getUser()->getSubscriptions()
        ]);
    }

    /**
     * @Route("/mes-souscriptions/{id}", name="subscription_show", methods={"GET"})
     */
    public function show(Subscription $subscription): Response
    {
        return $this->render('subscription/show.html.twig', [
            'subscription' => $subscription,
        ]);
    }
}
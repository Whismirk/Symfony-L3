<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Entity\Subscription;
use App\Form\OfferType;
use App\Repository\OfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mon-espace-client/offers")
 */
class OfferController extends AbstractController
{
    /**
     * @Route("/", name="offer_index", methods={"GET"})
     */
    public function index(OfferRepository $offerRepository): Response
    {
        return $this->render('offer/index.html.twig', [
            'offers' => $offerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="offer_show", methods={"GET"})
     */
    public function show(Offer $offer): Response
    {
        return $this->render('offer/show.html.twig', [
            'offer' => $offer,
        ]);
    }

    /**
     * @Route("/subscribe/{id}", name="offer_subscribe", methods={"GET"})
     */
    public function subscribe(Offer $offer)
    {
        if ($this->getUser() != null) 
        {
            $user = $this->getUser();
            $subscribed = false;
            foreach ($user->getSubscriptions() as $subscription) 
            {
                if($subscription->getOffer()->getId() == $offer->getId())
                {
                    $subscribed = true;
                    break;
                }
            }
            if($subscribed)
            {
                $this->addFlash('error', 'Vous êtes déjà abonné à cette offre !');
                return $this->redirectToRoute('offer_index');
            }
            else
            {
                if ($user->getPhone() != null && $user->getCity() != null && $user->getZipcode() != null && $user->getCountry() != null && $user->getSsn() != null)
                {
                    $subscription = new Subscription($user, $offer);
                    $user->addSubscription($subscription);
                    $offer->addSubscription($subscription);
                    
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($subscription);
                    $entityManager->persist($user);
                    $entityManager->persist($offer);
                    $entityManager->flush();
                }
                else
                {
                    $this->addFlash('error', 'Veuillez saisir les informations complémentaires dans votre espace client avant de souscrire à cette offre.');
                    return $this->redirectToRoute('user_home');
                }
            }
            return $this->redirectToRoute('user_subscriptions');
        }
        else 
        {
            $this->addFlash('error', 'Vous devez être connecté pour souscrire à une offre !');
            return $this->redirectToRoute('app_login');
        }
    }
}

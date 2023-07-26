<?php

namespace App\Controller\front;

use App\Entity\Listing;
use App\Form\ListingType;
use App\Repository\ListingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class HomeController extends AbstractController
{

    public function __construct(
        private ListingRepository $listingRepository,
        private TranslatorInterface $translator,
    )
    {
    }

    #[Route('/', name: 'app_home')]
    public function index(Request $request): Response
    {
        $listing = new Listing;
        $form = $this->createForm(ListingType::class, $listing);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->listingRepository->save($listing, true);

            $this->addFlash(
                'success',
                $this->translator->trans('listing.sucess.add')
            );
        }

        return $this->render('/front/pages/home/index.html.twig', [
            'listings' => $this->listingRepository->getLastListings(9),
            'form'=> $form->createView(),
        ]);
    }
}

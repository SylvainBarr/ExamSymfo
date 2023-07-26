<?php

namespace App\Controller\front;

use App\Repository\ListingRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/annonce', name: 'app_listing_')]
class ListingController extends AbstractController
{

    public function __construct(
        private ListingRepository $listingRepository,
    )
    {
    }

    #[Route('/', name: 'home')]
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $listings = $paginator->paginate(
            $this->listingRepository->getAllListingQb(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('front/pages/listing/index.html.twig', [
            'listings' => $listings,
        ]);
    }

    #[Route('/{id}', name: 'show')]
    public function show(string $id): Response
    {
        return $this->render('front/pages/listing/show.html.twig', [
            'listing' => $this->listingRepository->getFullOneById($id),
        ]);
    }
}

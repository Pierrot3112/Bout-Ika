<?php

namespace App\Controller\admin;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted("ROLE_ADMIN")]
class DashboardController extends AbstractController
{
    #[Route('/', name: 'app_dashboard')]
    public function index(ProduitRepository $produitRepository): Response
    {
        $produit = $produitRepository->findAll();
        return $this->render('dashboard/index.html.twig', [
            'produits'=> $produit
        ]);
        // return $this->render('dashboard/index.html.twig', [
        //     'controller_name' => 'DashboardController',
        // ]);
    }
}

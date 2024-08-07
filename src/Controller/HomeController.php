<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted("ROLE_USER")]
class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(ProduitRepository $repo): Response
    {
        $produit = $repo->findAll();
        return $this->render('home/index.html.twig', [
            'produits' => $produit,
        ]);
    }
}

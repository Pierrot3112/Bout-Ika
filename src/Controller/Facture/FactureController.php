<?php

namespace App\Controller\Facture;

use App\Repository\HistoriqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FactureController extends AbstractController
{
    #[Route('/facture', name: 'app_facture')]
    public function index(HistoriqueRepository $historiqueRepository): Response
    {
        $historique = $historiqueRepository->findAll();
        return $this->render('facture/index.html.twig', [
            'historiques' => $historique,
        ]);
    }
}

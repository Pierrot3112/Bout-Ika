<?php

namespace App\Controller;

use App\Repository\HistoriqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

// #[IsGranted("ROLE_USER")]
class HistoriqueController extends AbstractController
{
    #[Route('/historique', name: 'app_historique')]
    public function index(HistoriqueRepository $repo): Response
    {

        $historiques = $repo->findAll();

        return $this->render('historique/index.html.twig', [
            'historiques' => $historiques,
        ]);
    }
}

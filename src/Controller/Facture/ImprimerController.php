<?php

namespace App\Controller\Facture;

use PHPUnit\Framework\MockObject\Builder\InvocationMocker;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Flex\Options;

class ImprimerController extends AbstractController
{
    #[Route('/facture/imprimer', name: 'app_facture_imprimer')]
    public function index(): Response
    {
        $invoice = $this->renderView('MyBundle:Foo:bar.html.twig', array(
            'some' => $vars,
        ));
        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($invoice),
            200,
            array(
                'Content-Type'=> 'application/pdf',
                'Content-Disposition'=> 'attachement; filename="facture.pdf"'
            )
        );
    }
}

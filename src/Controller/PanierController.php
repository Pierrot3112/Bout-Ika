<?php

namespace App\Controller;

use App\DTO\PanierDTO;
use App\Entity\Panier;
use App\Form\PanierType;
use App\Repository\PanierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted("ROLE_USER")]
class PanierController extends AbstractController
{
public function __construct( private EntityManagerInterface $em){}

    #[Route('/panier', name: 'app_panier')]
    public function index(PanierRepository $panierRepository, Request $request): Response
    {

        $panierDto = new PanierDTO();
        $panier= new Panier();
        $paniers = $panierRepository->findAllNotValid();
        $form = $this->createForm(PanierType::class,$panierDto);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            /** @var \App\Entity\Produit $produit  */
            $produit = $form->get('produit')->getData();
            $panierProduits = $panierRepository->findAllProduct($produit);

            $totalCommande = 0;

            foreach($panierProduits as $p){
                $totalCommande += $p->getQuantite();
            }

            if(($produit->getNombre() - $totalCommande) < $panierDto->nombre) {
                $this->addFlash('error','stock insuffisant');
                return $this->redirectToRoute('app_panier');
            }

            $panier->setClient($panierDto->client)
                ->setProduit($panierDto->produit)
                ->setPrixUnitaire($panierDto->produit->getPrix())
                ->setQuantite($panierDto->nombre)
                ->setValidation(false)
                ->setDate(new \DateTime());

            $this->em->persist($panier);
            $this->em->flush();
            $this->addFlash('success', "Panier ajouté");
            return $this->redirectToRoute("app_panier");        }
        return $this->render('panier/index.html.twig', [
            'paniers_form' => $form,
            'paniers'=> $paniers
        ]);
    }
    
    #[Route('/panier/delete/{id}', name: 'app_panier_delete')]
    public function delete(int $id, PanierRepository $panierRepository): Response
    {
        $panier = $panierRepository->find($id);
       
        if(!empty($panier)){
            $this->em->remove($panier);
            $this->em->flush();
            $this->addFlash('success','Supprimer avec succès');
        }else{
            $this->addFlash('error','panier non existant');
        }

        return $this->redirectToRoute('app_panier');
    }
}

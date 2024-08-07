<?php

namespace App\Controller;
use App\Entity\Historique;
use App\Repository\PanierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted("ROLE_USER")]
class ValiderController extends AbstractController {
    
    #[Route("/historique/add", name:"add_historique")]
    public function validate(
        PanierRepository $panierRepository,
        EntityManagerInterface $em
    ) {
        
        $paniers = $panierRepository->findAllNotValid();

        /** @var \App\Entity\Utilisateur $user */
        $user = $this->getUser();
        
        foreach( $paniers as $panier ) {

            $produit = $panier->getProduit();

            $historique = new Historique();
            $historique->setClient($panier->getClient())
                ->setProduit($produit)
                ->setUtilisateur($user)
                ->setDate($panier->getDate())
                ->setPrixUnitaire($panier->getProduit()->getPrix())
                ->setQuantite($panier->getQuantite());

            //enregistrer les commandes dans la table historique
            $em->persist($historique);
            $em->flush();

            //mettre à jour les produits validés dans la table panier
            $panier->setValidation(true);
            $em->persist($panier);
            $em->flush();

            //Mettre à jour les données de la table produit
            $produit->setNombre($produit->getNombre() - $panier->getQuantite());
            $em->persist($produit);
            $em->flush();
        }

        $this->addFlash("success","commande validée");

        return $this->redirectToRoute("app_facture");
        

    }

}

?>
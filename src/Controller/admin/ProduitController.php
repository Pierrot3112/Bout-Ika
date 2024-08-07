<?php

namespace App\Controller\admin;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use TomasVotruba\BarcodeBundle\Base1DBarcode;

#[IsGranted("ROLE_ADMIN")]
class ProduitController extends AbstractController
{
    #[Route('/admin/produit', name: 'app_produit')]
    public function index(ProduitRepository $produitRepository): Response
    {

        $produit = $produitRepository->findAll();
        return $this->render('admin/stock/index.html.twig', [
            'produits'=> $produit
        ]);
    }
    
    #[Route('/admin/produit/add', name: 'add_produit')]
    public function addProduit(
        Request $request,
        EntityManagerInterface $em    
    ): Response
    {
        $produit= new Produit();
        $form = $this->createForm(ProduitType::class,$produit); 

        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ) {

            /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $form->get('thumbnail')->getData();

            if($file){
                $filename = 'produit' . (new \DateTime("now"))->format('U') .'.'. $file->getClientOriginalName();
                $file->move($this->getParameter('kernel.project_dir'). '/public/images/produit', $filename);
                $produit->setImage($filename);
            }

                    
            $em->persist($produit);
            $em->flush();

            $this->addFlash('success','Produit ajouté');
            return $this->redirectToRoute('app_produit');
        }

        return $this->render('admin/stock/add.html.twig', [
            'form' => $form,
        ]);
    }
    
    #[Route('/admin/produit/edit/{id}', name: 'update_produit')]
    public function editProduit(
        Produit $produit, 
        Request $request,
        EntityManagerInterface $em    
    ): Response
    {
        $form = $this->createForm(ProduitType::class,$produit); 

        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ) {

            /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $form->get('thumbnail')->getData();

            if($file){
                $filename = 'produit' . (new \DateTime("now"))->format('U') .'.'. $file->getClientOriginalName();
                $file->move($this->getParameter('kernel.project_dir'). '/public/images/produit', $filename);
                $produit->setImage($filename);
            }

            $em->persist($produit);
            $em->flush();

            $this->addFlash('success','Produit ajouté');
            return $this->redirectToRoute('app_produit');
        }

        return $this->render('admin/stock/add.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/admin/produit/delete/{id}', name:'delete_produit')]
    public function deleteProduit(int $id,ProduitRepository $produitRepository, EntityManagerInterface $em): Response{
       
        $produit = $produitRepository->find($id);
       
        if(!empty($produit)){
            $em->remove($produit);
            $em->flush();
            $this->addFlash('success','Supprimer avec succès');
        }else{
            $this->addFlash('error','Produit non existant');
        }

        return $this->redirectToRoute('app_produit');
    }

}

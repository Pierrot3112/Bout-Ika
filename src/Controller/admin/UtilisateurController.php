<?php

namespace App\Controller\admin;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted("ROLE_ADMIN")]
class UtilisateurController extends AbstractController
{

    public function __construct(private EntityManagerInterface $em, private UtilisateurRepository $repo){

    }

    #[Route('/admin/utilisateur', name: 'app_admin_utilisateur')]
    public function index(): Response
    {
        $user = $this->repo->findAll();
        return $this->render('admin/utilisateur/index.html.twig', [
            'users' => $user,
        ]);
    }

    
    #[Route('/admin/utilisateur/add', name: 'add_utilisateur')]
    public function add(Request $request, UserPasswordHasherInterface $hr): Response
    {
        $utilisateur = new Utilisateur();
        
        $form = $this->createForm(UtilisateurType::class,$utilisateur); 

        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ) {

             /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $file */
             $file = $form->get('thumbnail')->getData();

             if($file){
                 $filename = 'produit' . (new \DateTime("now"))->format('U') .'.'. $file->getClientOriginalName();
                 $file->move($this->getParameter('kernel.project_dir'). '/public/images/utilisateur', $filename);
                 $utilisateur->setImage($filename);
             }

             $utilisateur->setPassword($hr->hashPassword($utilisateur, $form->get('pass')->getData()));
            $this->em->persist($utilisateur);
            $this->em->flush();
            $this->addFlash('success','Utilisateur ajouter avec succès');
            return $this->redirectToRoute('app_admin_utilisateur');
        }

        return $this->render('admin/utilisateur/add.html.twig', [
            'form' => $form,
        ]);
    }
    
    #[Route('/admin/utilisateur/edit/{id}', name: 'update_user')]
    public function update(Request $request, Utilisateur $utilisateur): Response
    {
        
        $form = $this->createForm(UtilisateurType::class,$utilisateur); 

        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ) {
            $this->em->persist($utilisateur);
            $this->em->flush();
            $this->addFlash('success','Client ajouter avec succès');
            return $this->redirectToRoute('app_admin_client');
        }


        return $this->render('admin/client/add.html.twig', [
            'form'=> $form
        ]);
    }
    

    #[Route('/admin/utilisateur/delete/{id}', name:'delete_user')]
    public function deleteClient(int $id): Response{
       
        $utilisateur = $this->repo->find($id);
       
        if(!empty($utilisateur)){
            $this->em->remove($utilisateur);
            $this->em->flush();
            $this->addFlash('success','Supprimer avec succès');
        }else{
            $this->addFlash('error','utilisateur non existant');
        }

        return $this->redirectToRoute('app_admin_utilisateur');
    }
}

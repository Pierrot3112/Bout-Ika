<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

// #[IsGranted("ROLE_USER","ROLE_ADMIN")]
class ClientController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em, private ClientRepository $repo){

    }

    #[Route('/admin/client', name: 'app_admin_client')]
    public function index(): Response
    {

        $clients = $this->repo->findAll();
        return $this->render('admin/client/index.html.twig', [
            'clients' => $clients,
        ]);
    }
    
    #[Route('/admin/client/add', name: 'add_client')]
    public function add(Request $request): Response
    {
        $client = new Client();
        
        $form = $this->createForm(ClientType::class,$client); 

        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ) {
            $this->em->persist($client);
            $this->em->flush();
            $this->addFlash('success','Client ajouter avec succès');
            return $this->redirectToRoute('app_admin_client');
        }


        return $this->render('admin/client/add.html.twig', [
            'form'=> $form
        ]);
    }
    
    #[Route('/admin/client/edit/{id}', name: 'update_client')]
    public function update(Request $request, Client $client): Response
    {
        
        $form = $this->createForm(ClientType::class,$client); 

        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ) {
            $this->em->persist($client);
            $this->em->flush();
            $this->addFlash('success','Client ajouter avec succès');
            return $this->redirectToRoute('app_admin_client');
        }


        return $this->render('admin/client/add.html.twig', [
            'form'=> $form
        ]);
    }
    

    #[Route('/admin/client/delete/{id}', name:'delete_client')]
    public function deleteClient(int $id): Response{
       
        $client = $this->repo->find($id);
       
        if(!empty($client)){
            $this->em->remove($client);
            $this->em->flush();
            $this->addFlash('success','Supprimer avec succès');
        }else{
            $this->addFlash('error','Client non existant');
        }

        return $this->redirectToRoute('app_admin_client');
    }
}

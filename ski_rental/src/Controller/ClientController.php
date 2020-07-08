<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Client;
use App\Form\ClientType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/client", name="client")
 */
class ClientController extends AbstractController
{
    
    public function default(Request $request): Response
    {

        $msg = ($request->query->get('message'))? $request->query->get('message'):'';
        $clientList = $this->list();
        $form = $this->createForm(ClientType::class);
        return $this->render('client/add.html.twig', ['message' => $msg,'clients' => $clientList,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/add", name="add_client")
     */
    public function newClient(Request $request){
            // just setup a fresh $task object (remove the example data)
        $client = new Client();

        $form = $this->createForm(ClientType::class, $client);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $client = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($client);
            $entityManager->flush();

        }
        
        $msg = 'Client ajouté';
         $form = $this->createForm(ClientType::class);
        return $this->redirectToRoute('client',['message' => $msg]);    
    }

    public function list(){
        return $clients = $this->getDoctrine()
        ->getRepository(Client::class)
        ->findAll();
    }
}
?>
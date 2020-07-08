<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Marques;
use App\Form\MarquesType;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/marques", name="client")
 */
class MarquesController extends AbstractController
{
    
    public function default(): Response
    {
        $msg = '';
        $form = $this->createForm(MarquesType::class);
        return $this->render('marques/add.html.twig', ['message' => $msg,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/add", name="add_client")
     */
    public function newMarque(Request $request){
            // just setup a fresh $task object (remove the example data)
        $marque = new Marques();

        $form = $this->createForm(MarquesType::class, $marque);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $marque = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($marque);
            $entityManager->flush();

        }
        
        $msg = 'Marque ajoutée';
         $form = $this->createForm(MarquesType::class);
        return $this->render('marques/add.html.twig', ['message' => $msg,
            'form' => $form->createView(),
        ]);      
    }

    public function list(){
        return $clients = $this->getDoctrine()
        ->getRepository(Marques::class)
        ->findAll();
    }
}
?>
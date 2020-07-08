<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Orders;
use App\Entity\RentalLines;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use App\Form\RentalsType;
use App\Form\RentalLinesType;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\Articles;

/**
 * @Route("/rentals", name="rentals")
 */
class RentalsController extends AbstractController
{
    
    public function default(): Response
    {
        $msg = '';
        $rentals = $this->list();
        $form = $this->createForm(RentalsType::class);
        return $this->render('rentals/add.html.twig', ['message' => $msg,
            'rentals' => $rentals,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/add", name="add_rental")
     */
    public function newRental(Request $request){
            // just setup a fresh $task object (remove the example data)
        $rental = new Orders();

        $form = $this->createForm(RentalsType::class, $rental);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $rental = $form->getData();
            $rental->setState(1);
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rental);
            $entityManager->flush();
            $msg = 'Location ajoutée';
            return $this->redirectToRoute('rentals',['message' => $msg]);  

        }
        
        $msg = 'Formulaire non valide';
         $form = $this->createForm(RentalsType::class);
        return $this->redirectToRoute('rentals',['message' => $msg]);     
    }

    public function list(){
        return $clients = $this->getDoctrine()
        ->getRepository(Rentals::class)
        ->findBy(['state' => 1]);
    }

    public function editRental(Request $request){

        $rentalId = $request->query->get('rental_id');

        $rental = $this->getDoctrine()
        ->getRepository(Rentals::class)
        ->findOneBy(['id' => $rentalId]);

        $msg ="Traitement en cours";
        $rentalLines = new RentalLines();
        $rentalLines->setRental($rental);
        $form = $this->createForm(RentalLinesType::class,$rentalLines);
        $rentalLines = $this->getDoctrine()
            ->getRepository(RentalLines::class)
            ->findBy(['Rental' => $rentalId]);
        return $this->render('rentals/edit.html.twig', ['message' => $msg,
        'rentals' => $rentalLines,
        'rental' => $rental,
            'form' => $form->createView(),
        ]);
    }

    public function modifyRental(Request $request){
            // just setup a fresh $task object (remove the example data)
        $rentalLine = new RentalLines();
        
        $form = $this->createForm(RentalLinesType::class, $rentalLine);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $rentalLine = $form->getData();
            $rentalLine->setState(1);
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rentalLine);
            $entityManager->flush();
            $msg = 'Location ajoutée';
            return $this->redirectToRoute('rentals_edit',['message' => $msg,'rental_id' => $rentalLine->getRental()->getId()]);  

        }
        
        $msg = 'Formulaire non valide';
        $form = $this->createForm(RentalsType::class);
        return $this->redirectToRoute('rentals',['message' => $msg,]);    
    }

    public function returnRental(Request $request){
        $rentalId = $request->query->get('rental_id');

        $entityManager = $this->getDoctrine()->getManager();
        $rental = $entityManager->getRepository(Rentals::class)->findOneBy(['id' => $rentalId]);

        if (!$rental) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $rental->setState(0);
        $entityManager->flush();

        
        $msg = 'Location retournée !';
        $form = $this->createForm(RentalsType::class);
        return $this->redirectToRoute('rentals',['message' => $msg,]);    
    }

    public function generateBill(Request $request){
        $rentalId = $request->query->get('rental_id');

        $entityManager = $this->getDoctrine()->getManager();
        $rental = $entityManager->getRepository(Rentals::class)->findOneBy(['id' => $rentalId]);

        if (!$rental) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }
        $rentalLines = $this->getDoctrine()
            ->getRepository(RentalLines::class)
            ->findBy(['Rental' => $rentalId]);

        $sql = '
            SELECT articles.label, rental_lines.start_date, rental_lines.end_date, DATEDIFF(end_date,start_date)*(SELECT daily_price FROM articles WHERE id = article_id) as prix FROM rental_lines
            JOIN articles ON articles.id = rental_lines.article_id
            JOIN rentals ON rental_lines.rental_id = rentals.id
            JOIN client ON rentals.client_id = client.id
            ';
        $conn = $this->getDoctrine()->getManager()->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // returns an array of arrays (i.e. a raw data set)
        $res = $stmt->fetchAll();

        $this->createBillFile($rental,$res);
            $msg = "Facture de la location : <br>";
        return $this->render('rentals/bill.html.twig', ['message' => $msg,
        'rentals' => $rentalLines,
        'rental' => $rental,
        ]);   
    }

    public function createBillFile($rental, array $rentalLines){
        $filesystem = new Filesystem();
        return;
    }
}
?>
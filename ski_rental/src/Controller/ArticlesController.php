<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Articles;
use App\Form\ArticlesType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ArticlesRepository;

/**
 * @Route("/articles", name="articles")
 */
class ArticlesController extends AbstractController
{
    
    public function default(Request $request): Response
    {
        $msg = ($request->query->get('message'))? $request->query->get('message'):'';
        $articles = $this->list();
        $allArticles = $this->listAll();
         $form = $this->createForm(ArticlesType::class);
        return $this->render('articles/add.html.twig', ['message' => $msg,
        'articles' => $articles,
        'allArticles' => $allArticles,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/add", name="articles_add")
     */
    public function newArticle(Request $request){
            // just setup a fresh $task object (remove the example data)
        $article = new Articles();
        $articles = $this -> list();

        $form = $this->createForm(ArticlesType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $client = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
            $msg = 'Article ajouté';
        }
        
        $msg = 'Erreur dans le formulaire';
        return $this->redirectToRoute('articles',['message' => $msg]);       
    }

    public function list(){
        return $articles = $this->getDoctrine()->getManager()
        ->createQuery(
            'SELECT p FROM App\Entity\Articles p WHERE p.id != ALL(SELECT IDENTITY(r.Article) FROM App\Entity\RentalLines r)'
        )->getResult();
    }

    public function listAll(){
        return $articles = $this->getDoctrine()->getManager()
        ->getRepository(Articles::class)->findAll();
    }
}
?>
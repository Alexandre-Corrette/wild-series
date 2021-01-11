<?php
// src/Controller/CategoryController.php
namespace App\Controller;

use App\Entity\Program;
use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/categories", name="category_")
 * @return Response
 */
class CategoryController extends AbstractController
{
/**
 * @Route("/", name="index")
 * @return Response
 */
    public function index(): Response
    {
        $categories = $this->getDoctrine()
             ->getRepository(Category::class)
             ->findAll();

        return $this->render('category/index.html.twig',
        ['categories' => $categories]
        );
        
        
    }
    /**
     * The controller for the category add form
     *
     * @Route("/new", name="new")
     */
    public function new(Request $request): Response
    {
        //Create a new Category Object
        $category = new Category();
        //Create the assiociated Form
        $form = $this->createForm(CategoryType::class, $category);
        //Get data from http request
        $form->handleRequest($request);
        //was the form submitted?
        if ($form->isSubmitted()){
            // Deal with the submitted data
            // Get the EntityManager
            $entityManager = $this->getDoctrine()->getManager();
            //Persist Category Object
            $entityManager->persist($category);
            //Flush the persisted object
            $entityManager->flush();
            // And redirect to a route that display the result
            return $this->redirectToRoute('category_index');
        }
        //render the Form 
        return $this->render('category/new.html.twig', [
            "form" => $form->createView(),
        ]);
    }
    /**
     * @Route("/show/{categoryName}", methods={"GET"}, name="show")
     * @return Response
     */
        public function findByCategory(string $categoryName)
        {
            $category = $this->getDoctrine()
                ->getRepository(Category::class)
                ->findOneBy(['name' => $categoryName]);

            if (!$categoryName) {
                throw $this->createNotFoundException(
                    'No program with name : '.$categoryName.' found in program\'s table.'
                );
            }
            $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findBy(['category' => $category], ['id' => 'DESC'], 3);

            return $this->render('category/show.html.twig', [
                'category' => $category, 'programs' => $programs
            ]);
        }
 
}
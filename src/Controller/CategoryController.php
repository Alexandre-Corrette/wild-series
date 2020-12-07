<?php
// src/Controller/CategoryController.php
namespace App\Controller;

use App\Entity\Program;
use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/categories", name="category_")
 * @return Response
 */
class CategoryController extends AbstractController
{
/**
 * @Route("/", name="index_")
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
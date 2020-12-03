<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ProgramController extends AbstractController
{
    /**
     * @Route("/program/", name="program_index")
     * @return Response
     */
    public function index(ProgramRepository $programRepository): Response
    {
        
        return $this->render('program/index.html.twig', [
            'website' => 'Wild Séries',
         ]);

    }
    /**
     * @Route("/program/show/{id<\d+>}", methods={"GET"}, name="program_show")
     * @return Response
     */
    public function show(int $id)
    {
        return $this->render('program/show.html.twig', ['id' => $id]);
    }
}
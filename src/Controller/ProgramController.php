<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Program;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
 

class ProgramController extends AbstractController
{/**
     * @Route("/program/", name="index")
     * @return Response
     */
   
    public function index(): Response
    {
        $programs = $this->getDoctrine()
             ->getRepository(Program::class)
             ->findAll();

        return $this->render('program/index.html.twig',
        ['programs' => $programs]
        );
        
        
    }
    
    /**
     * @Route("/program/show/{id<\d+>}", methods={"GET"}, name="program_show")
     * @return Response
     */
    public function show(int $id)
    {
        $program = $this->getDoctrine()
        ->getRepository(Program::class)
        ->findOneBy(['id' => $id]);

    if (!$program) {
        throw $this->createNotFoundException(
            'No program with id : '.$id.' found in program\'s table.'
        );
    }
    return $this->render('program/show.html.twig', [
        'program' => $program,
    ]);
        
    }
}
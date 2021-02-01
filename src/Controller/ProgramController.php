<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Season;
use App\Entity\Episode;
use App\Entity\Program;
use App\Form\ProgramFormType;
use App\Repository\SeasonRepository;
use App\Repository\ProgramRepository;
use App\Repostitory\EpisodeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

 /**
  * @Route("/programs", name="program_")
  * @return Response
  */
class ProgramController extends AbstractController
{
/**
  * @Route("/", name="index")
  * @return Response
  */
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();

        return $this->render('program/index.html.twig',
        ['programs' => $programs]
        );
        
        
    }
/**
 *  @Route("/new", name="new")
 * @return Response
 */
public function new(Request $request): Response
{
    // Create a new Program
    $program = new Program();
    //Create the assiociated Form
    $form = $this->createForm(ProgramFormType::class, $program);
    //Get data from http request
    $form->handleRequest($request);
    //Was the form submitted ?
    if ($form->isSubmitted() && $form->isValid()) {
        //Deal with the submitted Data
        //Get the EntityManager
        $entityManager = $this->getDoctrine()->getManager();
        //Persist Program Object
        $entityManager->persist($program);
        //Flush the persisted object
        $entityManager->flush();
        //Finally redirect to program list
        return $this->redirectToRoute('program_index');

    }
    // Render the form 
    return $this->render('program/new.html.twig', [
        "form" => $form->createView(),
    ]);
}
    
/**
 * @Route("/show/{id}", name="show")
 * @return Response
 */
    public function show(Program $program):response
    {
        $programs = $this->getDoctrine()
        ->getRepository(Program::class)
        ->findOneBy([]);
        $seasons = $programs->getSeasons();

    if (!$program) {
        throw $this->createNotFoundException(
            'No program with id : '.$id.' found in program\'s table.'
        );
    }
    return $this->render('Program/show.html.twig', [
        'program' => $program, 'seasons' => $seasons,
    ]);
        
    }
/**
 * @Route("/{program}/seasons/{season}", name="season_show")
 * @return Response
 */
    public function showSeason(Program $program, Season $season)
    {
        $program = $this->getDoctrine()
        ->getRepository(Program::class)
        ->findOneBy([]);
        $season = $this->getDoctrine()
        ->getRepository(Season::class)
        ->findOneBy([]);
        $episodes = $season->getEpisodes();

    if (!$program) {
        throw $this->createNotFoundException(
            'No program with id : '.$id.' found in program\'s table.'
        );
    }
    return $this->render('Program/season_show.html.twig', [
        'program' => $program, 'season' => $season, 'episodes' => $episodes,
    ]);
    }

/**
 * @Route("/{program}/seasons/{season}/episodes/{episode}", name="episode_show")
 * @return Response
 */
    public function showEpisode(Program $program, Season $season, Episode $episode) 
    {
        $program = $this->getDoctrine()
        ->getRepository(Program::class)
        ->findOneBy([]);
        $season = $this->getDoctrine()
        ->getRepository(Season::class)
        ->findOneBy([]);
        $episodes = $this->getDoctrine()
        ->getRepository(Episode::class)
        ->findOneBy([]);

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : '.$id.' found in program\'s table.'
            );
        }
        return $this->render('Program/episode_show.html.twig', [
            'program' => $program, 'season' => $season, 'episode' => $episodes,
        ]);
    }

}
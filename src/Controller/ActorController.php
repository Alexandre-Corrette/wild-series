<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Actor;
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
 * @Route("/actor", name="actor_")
* @return Response
*/
class ActorController extends AbstractController
{

/**
 * @Route("/show/{id}", name="show")
 * @return Response
 */
    public function actorShow(Actor $actor): response
    {
        $actors = $this->getDoctrine()
        ->getRepository(Actor::class)
        ->findOneBy([]);
        //dd($actor);

        if (!$actor) {
            throw $this->createNotFoundException(
                'No actor with id : '.$id.' found in actor\'s table.'
            );
        }
        return $this->render('actor/actor_show.html.twig', [
         'actors' => $actor,
        ]);
    }

}
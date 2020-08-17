<?php

namespace App\Controller;

use App\Entity\Megaman;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/megaman")
 */
class MegamanController extends AbstractController
{
	/**
	 * @Route("/create", name="create_random_megaman", methods={"GET"})
	 */
	public function createRandomMegaman(): Response {
		$men = ['Fire', 'Snow', 'Fart', 'Air', 'Earth', 'Food', 'Cat', 'Forest', 'Mint'];

		$random_megaman = new Megaman(
			rand(1, 100), 
			(new \DateTime)->modify('-'.rand(0, 70).' years, -'.rand(0, 11).' months, -'.rand(0, 364).' days'), 
			$men[array_rand($men)].'man'
		);

		$entity_manager = $this->getDoctrine()->getManager();
		$entity_manager->persist($random_megaman);
		$entity_manager->flush();

		$id = $random_megaman->getId();

		return new Response("New megaman number $id has just been created!");
	}
	/**
	 * @Route("/see", name="see_megamen", methods={"GET"})
	 */
	public function seeMegamen(): Response {
		$repository = $this->getDoctrine()->getRepository(Megaman::class);

		return $this->render('megaman/seeMegamen.html.twig', ['megamen' => $repository->findAll()]);
	}
}
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
	 * @Route("/details/{id}", name="see_megamen", methods={"GET"})
	 */
	public function details(int $id): Response {
		$megaman = $this->getDoctrine()->getRepository(Megaman::class)->find($id);
		if ($megaman !== NULL) 
			return $this->render('/megaman/megamanDetails.html.twig', ['megaman' => $megaman]);
		else
			return new Response('No such megaman');
	}
}
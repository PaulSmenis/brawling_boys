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
	 * @Route("/see", name="see_megamen", methods={"GET"})
	 */
	public function seeMegamen(): Response {
		$repository = $this->getDoctrine()->getRepository(Megaman::class);

		return $this->render('megaman/seeMegamen.html.twig', ['megamen' => $repository->findAll()]);
	}
}
<?php

namespace App\Controller;

use App\Entity\Megaman;
use App\Service\MegamanService;
use App\Service\BattleService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/megaman")
 */
class MegamanController extends AbstractController
{

	private $megaman_service;
	private $battle_service;

	public function __construct(MegamanService $megaman_service, BattleService $battle_service) 
	{
		$this->megaman_service = $megaman_service;
		$this->battle_service = $battle_service;
	}

	/**
	 * @Route("/details/{id}", name="detalis_megamen", methods={"GET"})
	 */
	public function details(int $id): Response 
	{
		$megaman = $this->getDoctrine()->getRepository(Megaman::class)->find($id);
		if ($megaman !== NULL) 
			return $this->render('/megaman/megamanDetails.html.twig', ['megaman' => $megaman]);
		else
			return new Response('No such megaman');
	}

	/**
	 * @Route("/test_battle", name="test_battle_megaman", methods={"GET"})
	 */
	public function battle(): Response 
	{
		$parts = $this->megaman_service->generateBodypartList();
		$random_part = fn() => $parts[array_rand($parts)];

		list($megaman_1, $megaman_2) = $this->megaman_service->createRandomMegamen(2);

		$log = [];

		$this->battle_service->setFoe1($megaman_1);
		$this->battle_service->setFoe2($megaman_2);

		$turn = 0;

		while ($this->battle_service->isAlive($megaman_1) &&
		       $this->battle_service->isAlive($megaman_2)) {

			$log[] = $this->battle_service->attack($turn, $random_part());
			$turn = ($turn) ? 0 : 1;
		}	// Можно ещё станы добавить, типа два и более подряд, но я не успел
		
		$log[] = ($this->battle_service->isAlive($megaman_1) ? $megaman_2->getName() : $megaman_1->getName()) . ' is dead!';
		return $this->render('/megaman/megamanBattleDemoLog.html.twig', ['log' => $log]);
	}
}
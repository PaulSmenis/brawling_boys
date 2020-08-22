<?php

namespace App\Controller;

use App\Entity\Megaman;
use App\Service\MegamanService;
use App\Service\BattleService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\MegamanRepository;

/**
 * @Route("/megaman")
 */
class MegamanController extends AbstractController
{
    /**
     * @Route("/details/{id}", name="detalis_megamen", methods={"GET"})
     */
    public function details(int $id): Response 
    {
        $megaman = $this->getDoctrine()->getRepository(Megaman::class)->find($id);
        if ($megaman !== null) 
            return $this->render('/megaman/megamanDetails.html.twig', ['megaman' => $megaman]);
        else
            return new Response('No such megaman');
    }

    /**
     * @Route("/test_battle", name="test_battle_megaman", methods={"GET"})
     */
    public function battle(MegamanService $megaman_service, 
                            BattleService $battle_service, 
                            MegamanRepository $repository): Response 
    {
        $foe_1 = $repository->find(1);
        $foe_2 = $repository->find(2);
        $log = $battle_service->battle($foe_1, $foe_2);
        return $this->render('/megaman/megamanBattleDemoLog.html.twig', ['log' => $log]);
    }
}
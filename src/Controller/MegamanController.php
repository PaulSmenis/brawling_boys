<?php

namespace App\Controller;

use App\Entity\Megaman;
use App\Service\BattleService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\FightParametersType;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/megaman")
 */
class MegamanController extends AbstractController
{
    /**
     * @Route("/details/{id}", name="detalis_megamen", methods={"GET"})
     * @param Megaman $megaman
     * @return Response
     */
    public function details(Megaman $megaman): Response 
    {
        return $this->render('/megaman/megamanDetails.html.twig', ['megaman' => $megaman]);
    }

    /**
     * @Route("", name="list_megamen", methods={"GET"})
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function list(Request $request, PaginatorInterface $paginator): Response 
    {
        $megamanRepository = $this->getDoctrine()->getRepository(Megaman::class);
        $data = $paginator->paginate(
            $megamanRepository->createQueryBuilder('a'),
            $request->query->getInt('page', 1),
            $request->query->getInt('pageSize', 10)
        );
        return $this->render('megaman/megamanList.html.twig', [
            'pagination' => $data
        ]);
    }

    /**
     * @Route("/test_battle", name="test_battle_megaman", methods={"GET", "POST"})
     * @param Request $request
     * @param BattleService $battle_service
     * @return Response
     */
    public function battle(Request $request, BattleService $battle_service): Response 
    {
       $form = $this->createForm(FightParametersType::class, $battle_service);
        // $foe_1 = $repository->find(1);
        // $foe_2 = $repository->find(2);
        // $log = $battle_service->battle($foe_1, $foe_2);
        // return $this->render('/megaman/megamanBattleDemoLog.html.twig', ['log' => $log]);
       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) {
            return $this->render(
                '/megaman/megamanBattleDemoLog.html.twig', [
                    'log' => $battle_service->battle()
                ]
            );
       }

       return $this->render('megaman/megamanBattleForm.html.twig', [
            'my_test_form' => $form->createView() // Данные с формы -- post (duh)
       ]);
    }
}
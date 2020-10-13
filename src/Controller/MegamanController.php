<?php

namespace App\Controller;

use App\Entity\Megaman;
use App\Repository\MegamanRepository;
use App\Service\BattleService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/megaman")
 */
class MegamanController extends AbstractController
{
    /**
     * @Route("/details/{id}", name="details", methods={"GET"})
     * @param Megaman $megaman
     * @return Response
     */
    public function details(Megaman $megaman): Response 
    {
        return $this->render('/megaman/megamanDetails.html.twig', 
                            ['megaman' => $megaman]);
    }

    /**
     * @Route("/list", name="list", methods={"GET"})
     * @param Request $request
     * @param MegamanRepository $megamanRepo
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function list(Request $request, MegamanRepository $megamanRepo,
                         PaginatorInterface $paginator): Response
    {   
        $page = $paginator->paginate(
            $megamanRepo->findAll(),
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('megaman/megamanList.html.twig', 
                            ['megaman_list' => $page]);
    }
}
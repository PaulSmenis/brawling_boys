<?php

namespace App\Controller;

use App\Entity\Megaman;
use App\Repository\MegamanRepository;
use App\Service\BattleService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
        die(var_dump($megaman));
        return $this->render('/megaman/megamanDetails.html.twig', 
                            ['megaman' => $megaman]);
    }

    /**
     * @Route("/list", name="list", methods={"GET"})
     * @param MegamanRepository $megamanRepo
     * @return Response
     */
    public function list(MegamanRepository $megamanRepo): Response 
    {
        return $this->render('megaman/megamanList.html.twig', 
                            ['megaman_list' => $megamanRepo->findAll()]);
    }
}
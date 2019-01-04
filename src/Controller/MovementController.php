<?php
/**
 * Created by PhpStorm.
 * User: Borja
 * Date: 04/01/2019
 * Time: 13:15
 */

namespace App\Controller;


use App\Entity\Movement;
use App\Form\Movement\MovementCreateFormType;
use App\Repository\MovementRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MovementController
 * @package App\Controller
 * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
 * @Route("/movement")
 */
class MovementController extends BaseController
{

    /**
     * @Route("/", name="movement_list")
     * @param Request $request
     * @param MovementRepository $movementRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function list(Request $request, MovementRepository $movementRepository)
    {
        $user = $this->getUser();

        $movement = new Movement();
        $movement->setAuthor($user);

        $form = $this->createForm(MovementCreateFormType::class, $movement);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($movement);
            $this->em->flush();
        }

        $movements = $movementRepository->findBy(['author' => $user]);

        return $this->render('movement/list.html.twig', [
            'movements' => $movements,
            'form' => $form->createView(),
        ]);
    }
}
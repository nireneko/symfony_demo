<?php
/**
 * Created by PhpStorm.
 * User: Borja
 * Date: 26/12/2018
 * Time: 1:49
 */

namespace App\Controller;


use App\Entity\Progress;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

/**
 * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
 */
class DefaultController extends BaseController
{

    /**
     * @Route("/", name="index")
     * @param RouterInterface $router
     * @return RedirectResponse
     */
    public function index(RouterInterface $router)
    {
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/home", name="home")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function home()
    {
        $user = $this->getUser();

        $progressRepository = $this->em->getRepository(Progress::class);

        $lowerProgress = $progressRepository->findOneBy(['author' => $user], ['weight' => 'ASC']);

        $lastProgresses =  $progressRepository->findBy(['author' => $user], ['date' => 'DESC'], 10);

        return $this->render('home.html.twig', [
            'lower_progresses' => $lowerProgress,
            'last_progresses' => $lastProgresses,
        ]);
    }

}
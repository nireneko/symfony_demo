<?php
/**
 * Created by PhpStorm.
 * User: Borja
 * Date: 26/12/2018
 * Time: 16:55
 */

namespace App\Controller;


use App\Entity\Progress;
use App\Form\ProgressAddFormType;
use App\Repository\ProgressRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
 * @Route("/progress")
 */
class ProgressController extends BaseController
{

    /**
     * @Route("/", name="progress_list")
     * @param ProgressRepository $progressRepository
     * @param Request $request
     * @return Response
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function list(ProgressRepository $progressRepository, Request $request)
    {
        $user = $this->getUser();

        $progress = new Progress();

        $progress->setAuthor($this->getUser());

        $formAdd = $this->createForm(ProgressAddFormType::class, $progress);
        $formAdd->handleRequest($request);

        if ($formAdd->isSubmitted() && $formAdd->isValid()) {
            $this->em->persist($progress);
            $this->em->flush();

            $this->cache->deleteItem('progress_' . $user->getId());

            return $this->render('progress/_row_progress.html.twig', [
                'progress' => $progress
            ]);
        }

        $item = $this->cache->getItem('progress_' . $user->getId());

        if(!$item->isHit()) {
            $item->set($progressRepository->getAllProgressOfUser($user));
            $this->cache->save($item);
        }

        $progresses = $progressRepository->getAllProgressOfUser($user);//$item->get();

        if($request->isXmlHttpRequest()) {
            $html = $this->renderView('_form_add.html.twig', [
                'form_add' => $formAdd->createView(),
            ]);

            return new Response($html, 400);
        }

        return $this->render('progress/list.html.twig', [
            'form_add' => $formAdd->createView(),
            'user' => $user,
            'progresses' => $progresses
        ]);
    }

    /**
     * @Route("/ajax/delete/{id}", name="progress_delete_ajax", methods={"DELETE"})
     * @param Progress $progress
     * @return Response
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function deleteAjax(Progress $progress)
    {
        $this->em->remove($progress);
        $this->em->flush();

        $user = $this->getUser();
        $this->cache->deleteItem('progress_' . $user->getId());

        return new Response(null, 204);
    }
}
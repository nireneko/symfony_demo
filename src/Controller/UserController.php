<?php
/**
 * Created by PhpStorm.
 * User: Borja
 * Date: 25/12/2018
 * Time: 14:10
 */

namespace App\Controller;


use App\Form\UserAccountFormType;
use App\Form\UserPasswordChangeForm;
use App\Util\UserTools;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @package App\Controller
 * @Route("/user")
 * @IsGranted("ROLE_USER")
 */
class UserController extends BaseController
{

    /**
     * @Route("/account", name="account")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function account(Request $request)
    {

        $this->denyAccessUnlessGranted("IS_AUTHENTICATED_FULLY");

        $user = $this->getUser();

        $form = $this->createForm(UserAccountFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($user);
            $this->em->flush();
        }

        return $this->render('user/account.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    /**
     * @Route("/password-change", name="user_password_change")
     * @param Request $request
     * @param UserTools $userTools
     */
    public function changePassword(Request $request, UserTools $userTools)
    {

        $this->denyAccessUnlessGranted("IS_AUTHENTICATED_FULLY");

        $user = $this->getUser();

        $form = $this->createForm(UserPasswordChangeForm::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $form_data = $form->getData();

            $password = $form_data['password'];
            $userTools->changeUserPassword($user->getUsername(), $password);

            return $this->redirectToRoute('app_logout');
        }

        return $this->render('user/password_change.html.twig', [
            'form' => $form->createView()
            ]
        );
    }
}
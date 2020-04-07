<?php
/**
 * Copyright (C) 2017 Andrew SASSOYE
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, version 3.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

namespace JOBINGE\EntreprisesBundle\Controller;


use AEES\UserBundle\Entity\User;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Util\TokenGenerator;
use JOBINGE\EntreprisesBundle\Entity\Entreprises;
use JOBINGE\EntreprisesBundle\Form\Registration\RegisterConditionType;
use JOBINGE\EntreprisesBundle\Form\Registration\RegisterContactType;
use JOBINGE\EntreprisesBundle\Form\Registration\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\AccountStatusException;


class RegistrationController extends Controller
{
    public function registerAction(Request $request)
    {

        if ($this->isGranted('ROLE_JOBINGE_ENTREPRISE')) {
            return $this->redirectToRoute('jobinge.accountEntreprises.index');
        }


        if ($this->get('session')->get('jobinge_register_entreprise_condition')) {
            return $this->redirectToRoute('jobinge.registrationEntreprise.registerEntreprise');
        }

        $form = $this->get('form.factory')->create(RegisterConditionType::class, null);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->get('session')->set('jobinge_register_entreprise_condition', True);

            return $this->redirectToRoute('jobinge.registrationEntreprise.registerEntreprise');
        }

        return $this->render("JOBINGEEntreprisesBundle:registration:register.html.twig", array(
            "form" => $form->createView()
        ));
    }

    public function registerEntrepriseAction(Request $request)
    {
        $user = $this->getUser();

        //if ($user instanceof UserInterface) {
        //    $this->get('session')->getFlashBag()->set('sonata_user_error', 'sonata_user_already_authenticated');
        //
        //    return $this->redirect($this->generateUrl('sonata_user_profile_show'));
        //}

        if (!$this->get('session')->get('jobinge_register_entreprise_condition')) {
            return $this->redirectToRoute('jobinge.registrationEntreprise.register');
        }


        if ($this->get('session')->get('jobinge_register_entreprise') != NULL) {
            $entreprise = $this->get('session')->get('jobinge_register_entreprise');
        } else {
            $entreprise = new Entreprises();
        }

        $form = $this->get('form.factory')->create(RegisterType::class, $entreprise);


        $form->handleRequest($request);

        if ($request->isMethod('POST') && $form->isValid()) {
            $entreprise = $form->getData();

            $this->get('session')->set('jobinge_register_entreprise', $entreprise);

            return $this->redirectToRoute('jobinge.registrationEntreprise.registerContact');

        }


        return $this->render("JOBINGEEntreprisesBundle:registration:registerEntreprise.html.twig", array(
            'form' => $form->createView(),
        ));


    }

    public function registerContactAction(Request $request)
    {

        if (!$this->get('session')->get('jobinge_register_entreprise_condition')) {
            return $this->redirectToRoute('jobinge.registrationEntreprise.register');
        }

        if ($this->get('session')->get('jobinge_register_entreprise') == NULL) {
            return $this->redirectToRoute('jobinge.registrationEntreprise.registerEntreprise');
        }

        $user = new User();

        $form = $this->get('form.factory')->create(RegisterContactType::class, $user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $user = $form->getData();

            $entreprise = $this->get('session')->get('jobinge_register_entreprise');

            $entreprise->setContact(null);


            $this->get('session')->set('jobinge_register_entreprise_check', $user->getEmail());


            $user->setEnabled(False);


            $em = $this->getDoctrine()->getManager();

            $entreprise->setDateInscription(new \DateTime());
            $em->persist($entreprise);
            $em->flush();


            $user->setUsername("COMP-" . $entreprise->getDateInscription()->format("y") . str_pad($entreprise->getId(), 4, '0', STR_PAD_LEFT));
            $user->addRole('ROLE_JOBINGE_ENTREPRISE');

            $em->persist($user);
            $em->flush();

            $entreprise->setContact($user);

            $em->persist($entreprise);
            $em->flush();

            $this->get('session')->remove('jobinge_register_entreprise');
            $this->get('session')->remove('jobinge_register_entreprise_condition');

            return $this->redirectToRoute('jobinge.registrationEntreprise.registerCheckEmail');

        }


        return $this->render('JOBINGEEntreprisesBundle:registration:registerContact.html.twig', array(
            'form' => $form->createView(),
        ));

    }

    /**
     * Tell the user to check his email provider.
     *
     * @return Response
     *
     * @throws NotFoundHttpException
     */
    public function checkEmailAction()
    {
        $email = $this->get('session')->get('jobinge_register_entreprise_check');
        $this->get('session')->remove('jobinge_register_entreprise_check');
        $user = $this->get('fos_user.user_manager')->findUserByEmail($email);


        if (null === $user) {
            return $this->redirectToRoute('jobinge.registrationEntreprise.register');
        }

        $tokenGenerator = new TokenGenerator();

        $user->setConfirmationToken($tokenGenerator->generateToken());

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();


        $url = $this->generateUrl('jobinge.registrationEntreprise.confirm', array('token' => $user->getConfirmationToken()), UrlGeneratorInterface::ABSOLUTE_URL);


        $message = \Swift_Message::newInstance()
            ->setSubject("[Jobingé] Email de confirmation")
            ->setSender("noreply@aees.be", "A.E.E.S. ASBL")
            ->setTo($user->getEmail())
            ->setBody(
                $this->renderView(

                    'JOBINGEEntreprisesBundle:mail:registerConfirm.html.twig',
                    array(
                        'user' => $user,
                        'confirmationUrl' => $url
                    )
                ),
                'text/html'
            );

        $this->get('mailer')->send($message);


        return $this->render('JOBINGEEntreprisesBundle:registration:registerConfirm.html.twig', array(
            'user' => $user,
        ));
    }

    /**
     * Receive the confirmation token from user email provider, login the user.
     *
     * @param string $token
     *
     * @return RedirectResponse
     *
     * @throws NotFoundHttpException
     */
    public function confirmAction($token)
    {
        $user = $this->get('fos_user.user_manager')->findUserByConfirmationToken($token);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with confirmation token "%s" does not exist', $token));
        }

        $user->setConfirmationToken(null);
        $user->setEnabled(true);
        $user->setLastLogin(new \DateTime());

        $this->get('fos_user.user_manager')->updateUser($user);

        $response = $this->redirectToRoute('jobinge.accountEntreprises.index');


        $this->authenticateUser($user, $response);

        return $this->redirectToRoute('jobinge.accountEntreprises.index');
    }

    /**
     * Authenticate a user with Symfony Security.
     *
     * @param UserInterface $user
     * @param Response      $response
     */
    protected function authenticateUser(UserInterface $user, Response $response)
    {
        try {
            $this->get('fos_user.security.login_manager')->loginUser(
                $this->container->getParameter('fos_user.firewall_name'),
                $user,
                $response
            );
        } catch (AccountStatusException $ex) {
            // We simply do not authenticate users which do not pass the user
            // checker (not enabled, expired, etc.).
        }
    }

    /**
     * Tell the user his account is now confirmed.
     *
     * @return Response
     *
     * @throws AccessDeniedException
     */
    public function confirmedAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        return $this->render('JOBINGEEntreprisesBundle:registration:confirm.html.twig', array(
            'user' => $user,
        ));
    }

    /**
     * @param string $action
     * @param string $value
     */
    protected function setFlash($action, $value)
    {
        $this->get('session')->getFlashBag()->set($action, $value);
    }

    /**
     * @return string
     */
    protected function getEngine()
    {
        return $this->container->getParameter('fos_user.template.engine');
    }
}
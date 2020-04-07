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


use JOBINGE\EntreprisesBundle\Form\Account\EntrepriseType;
use JOBINGE\ForumBundle\Entity\Inscription;
use JOBINGE\ForumBundle\Entity\InscriptionElement;
use JOBINGE\ForumBundle\Form\Inscription\newType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AccountController extends Controller
{
    public function indexAction()
    {

        if (!$this->isGranted('ROLE_JOBINGE_ENTREPRISE')) {
            throw $this->createAccessDeniedException("Vous devez être une entreprise pour pouvoir acceder a cette partie de la plateforme");
        }

        $company = $this->getEntreprise($this->getUser());

        $em = $this->getDoctrine()->getManager();

        $forum = $em->getRepository('JOBINGEForumBundle:Forum')->getActiveForum();

        $isInscrit = $em->getRepository('JOBINGEForumBundle:Inscription')->isInscrit($company, $forum);

        $inscription = $em->getRepository('JOBINGEForumBundle:Inscription')->getActualInscription($company, $forum);


        return $this->render('@JOBINGEEntreprises/account/index.html.twig', array(
            'company' => $company,
            'isInscrit' => $isInscrit,
            'inscription' => $inscription
        ));
    }

    private function getEntreprise($user)
    {

        $em = $this->getDoctrine()->getManager();

        $companyRep = $em->getRepository('JOBINGEEntreprisesBundle:Entreprises');

        return $companyRep->getByContact($this->getUser());
    }

    public function registrationsAction()
    {

        if (!$this->isGranted('ROLE_JOBINGE_ENTREPRISE')) {
            throw $this->createAccessDeniedException("Vous devez être une entreprise pour pouvoir acceder a cette partie de la plateforme");
        }

        $company = $this->getEntreprise($this->getUser());

        $em = $this->getDoctrine()->getManager();

        $forum = $em->getRepository('JOBINGEForumBundle:Forum')->getActiveForum();

        $isInscrit = $em->getRepository('JOBINGEForumBundle:Inscription')->isInscrit($company, $forum);


        return $this->render('@JOBINGEEntreprises/account/inscriptions.html.twig', array(
            'company' => $company,
            'isInscrit' => $isInscrit
        ));
    }

    public function registrationNewAction(Request $request)
    {
        //return $this->render('@JOBINGESite/Default/construction.html.twig');

        if (!$this->isGranted('ROLE_JOBINGE_ENTREPRISE')) {
            throw $this->createAccessDeniedException("Vous devez être une entreprise pour pouvoir acceder a cette partie de la plateforme");
        }

        $company = $this->getEntreprise($this->getUser());

        $em = $this->getDoctrine()->getManager();

        $forum = $em->getRepository('JOBINGEForumBundle:Forum')->getActiveForum();

        if ($em->getRepository('JOBINGEForumBundle:Inscription')->isInscrit($company, $forum)) {
            return $this->redirectToRoute('jobinge.accountEntreprises.registrations');
        }

        $packs = $em->getRepository('JOBINGEForumBundle:Packs')->findAll();

        $form = $this->get('form.factory')->create(newType::class, null, array(
            'packs' => $packs,
            'forum' => $forum
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {

            $data = $form->getData();

            $inscription = new Inscription();
            $inscription
                ->setCompany($company)
                ->setForum($forum)
                ->setCommentaire($data['Commentaire'])
                ->addDate($forum->getDates()[$data['Date']])
                ->setStatus(1)
                ->setStatusInterne(0)
                ->setCreated(new \DateTime());

            $pack = new InscriptionElement();
            $pack
                ->setInscription($inscription)
                ->setNom($packs[$data['Pack']]->getNom())
                ->setQuantite(1)
                ->setPrixUnit($packs[$data['Pack']]->getPrix())
                ->setType(0);
            $inscription->addElement($pack);

            $table = new InscriptionElement();
            if ($data['Table'] == 'haute') {

                $table
                    ->setInscription($inscription)
                    ->setNom('Table haute')
                    ->setQuantite(1)
                    ->setPrixUnit(0)
                    ->setType(1);
            } else {
                $table
                    ->setInscription($inscription)
                    ->setNom('Table basse')
                    ->setQuantite(1)
                    ->setPrixUnit(0)
                    ->setType(1);
            }
            $inscription->addElement($table);


            if ($data['brochure'] == true) {
                $brochure = new InscriptionElement();
                $brochure
                    ->setInscription($inscription)
                    ->setNom('Page supplémentaire brochure')
                    ->setQuantite(1)
                    ->setPrixUnit(100)
                    ->setType(1);
                $inscription->addElement($brochure);
            }

            if ($data['repas'] > 0) {
                $repas = new InscriptionElement();
                $repas
                    ->setInscription($inscription)
                    ->setNom('Repas supplémentaire\'')
                    ->setQuantite($data['repas'])
                    ->setPrixUnit(25)
                    ->setType(1);
                $inscription->addElement($repas);
            }

            $em->persist($inscription);
            $em->flush();
            return $this->redirectToRoute('jobinge.accountEntreprises.index');
        }


        return $this->render('@JOBINGEEntreprises/account/inscriptionNew.html.twig', array(
            'company' => $company,
            'forum' => $forum,
            'form' => $form->createView()
        ));
    }

    public function confirmProfileAction()
    {
        if (!$this->isGranted('ROLE_JOBINGE_ENTREPRISE')) {
            throw $this->createAccessDeniedException("Vous devez être une entreprise pour pouvoir acceder a cette partie de la plateforme");
        }

        $company = $this->getEntreprise($this->getUser());

        $em = $this->getDoctrine()->getManager();

        $forum = $em->getRepository('JOBINGEForumBundle:Forum')->getActiveForum();


        $inscription = $em->getRepository('JOBINGEForumBundle:Inscription')->getActualInscription($company, $forum);

        $inscription->setConfirmProfile(true);

        $em->persist($inscription);
        $em->flush();

        return $this->redirectToRoute('jobinge.accountEntreprises.index');
    }

    public function editEntrepriseAction(Request $request)
    {

        if (!$this->isGranted('ROLE_JOBINGE_ENTREPRISE')) {
            throw $this->createAccessDeniedException("Vous devez être une entreprise pour pouvoir acceder a cette partie de la plateforme");
        }

        $company = $this->getEntreprise($this->getUser());

        $form = $this->get('form.factory')->create(EntrepriseType::class, $company);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $company = $form->getData();

            $em->persist($company);
            $em->flush();

            $this->addFlash(
                'jobinge.account.success',
                'Les informations sur votre entreprise ont bien été mises à jour.'
            );

            return $this->redirectToRoute('jobinge.accountEntreprises.index');
        }

        return $this->render('@JOBINGEEntreprises/account/entreprise.html.twig', array(
            'form' => $form->createView()
        ));

    }


    public function testAction()
    {
        $url = $this->generateUrl('jobinge.registrationEntreprise.confirm', array('token' => '1234'), UrlGeneratorInterface::ABSOLUTE_URL);


        var_dump($url);
        die;
    }
}
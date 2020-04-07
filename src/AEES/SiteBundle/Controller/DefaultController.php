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

namespace AEES\SiteBundle\Controller;


use AEES\SiteBundle\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $form = $this->get('form.factory')->create(ContactType::class, null, array(
            'action' => $this->generateUrl('aees_site.contact'),
            'method' => 'POST'
        ));

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                if ($this->sendEmail($form->getData())) {
                    $this->addFlash('success', 'Message envoyé');

                    return $this->redirectToRoute('aees_site.contact');
                }
                $this->addFlash('success', 'Ce service est actuellement indisponible. veuillez envoyer votre mail a ca@aees.be');

            }
        }
        return $this->render('AEESSiteBundle::contact.html.twig', array(
            'form' => $form->createView()
        ));
    }

    private function sendEmail($data)
    {
        $myappContactMail = 'ca@aees.be';

        $message = \Swift_Message::newInstance()
            ->setFrom($data['email'])
            ->setSubject($data['subject'])
            ->setReplyTo($data['email'])
            ->setTo("ca@aees.be")
            ->setBody($data["message"]);

        return $this->get('mailer')->send($message);
    }

    public function testAction(Request $request)
    {
        echo "<pre>";
        dump($request);
        echo "</pre>";
        die;
    }
}
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

namespace JOBINGE\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class JobfairController extends Controller
{
    public function companyListAction()
    {
        $em = $this->getDoctrine()->getManager();

        $date1 = new \DateTime('2018-03-14');
        $qd1 = $em->getRepository('JOBINGEEntreprisesBundle:Entreprises')->getEntreprisesByDayAccepted($date1);

        $date2 = new \DateTime('2018-03-15');
        $qd2 = $em->getRepository('JOBINGEEntreprisesBundle:Entreprises')->getEntreprisesByDayAccepted($date2);

        return $this->render('JOBINGEForumBundle:jobfair:list.html.twig', array(
            'inscriptions1' => $qd1,
            'inscriptions2' => $qd2
        ));
    }

    public function companyShowAction($slug)
    {

        $em = $this->getDoctrine()->getManager();
        $company = $em->getRepository('JOBINGEEntreprisesBundle:Entreprises')->findOneByNomSlug($slug);

        if (!$company) {
            return $this->createNotFoundException("Cette entreprise n'existe pas");
        }

        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage
            ->setTitle($company->getNom());

        return $this->render('JOBINGEForumBundle:jobfair:show.html.twig', array(
            'company' => $company
        ));
    }

}
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


use Sonata\AdminBundle\Controller\CRUDController as BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class InscriptionCRUDController extends BaseController
{
    public function contractAction($id)
    {
        $request = $this->getRequest();
        $id = $request->get($this->admin->getIdParameter());

        $inscription = $this->admin->getObject($id);


        if (!$inscription) {
            throw new NotFoundHttpException(sprintf('Impossible de trouver l\'inscription avec l\'id: %s', $id));
        }

        $company = $inscription->getCompany();

        $elements = $inscription->getElements();

        $pack = $inscription->getPack();

        $text = "";
        if ($pack->getNom() == "FORUM ENTREPRISES « CLASSIQUE »") {

            $text = "Une surface d’exposition de 4 mètres de long. \\
L’accès à la partie privée de la plateforme Internet www.jobinge.be jusqu’au 30 septembre 2018. \\
Une conférence de 25 minutes dans un des locaux attenant au FORUM 2018 si la société le désir. \\
Deux pages en quadrichromie dans la brochure, remise gratuitement aux étudiants (une page de présentation de la société, une page de publicité) - fichier fourni par vos soins. \\
Trois slides dans la présentation PowerPoint défilant en permanence sur écran géant durant les 2 jours de l’évènement - fichier fourni par vos soins. \\
Les repas (dîner, goûter, boissons, café, ...) pour quatre personnes.\\";
        } elseif ($pack->getNom() == "FORUM ENTREPRISES « PME »") {
            $text = "Une surface d’exposition de 2 mètres de long. \\
L’accès à la partie privée de la plateforme Internet www.jobinge.be jusqu’au 30 septembre 2018. \\
Une conférence de 25 minutes dans un des locaux attenant au FORUM 2018 si la société le désir. \\
Deux pages en quadrichromie dans la brochure, remise gratuitement aux étudiants (une page de présentation de la société, une page de publicité) - fichier fourni par vos soins. \\
Trois slides dans la présentation PowerPoint défilant en permanence sur écran géant durant les 2 jours de l’évènement - fichier fourni par vos soins. \\
Les repas (dîner, goûter, boissons, café, ...) pour deux personnes.\\";
        }

        $otherOptions = $inscription->getOtherOptions();

        $total = $inscription->getTotal();


        $latexer = $this->get('jobinge.admin.latex');
        $latexer->escaper();

        $fileContent = $this->renderView('@JOBINGEForum/contact.tex.twig', array(
            'inscription' => $inscription,
            'company' => $company,
            'pack' => $pack,
            'text' => $text,
            'options' => $otherOptions,
            'total' => $total,
            'elements' => $elements
        )); // the generated file content
        $response = new Response($fileContent);

        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'contract-' . $inscription->getIdentifier() . '.tex'
        );

        $response->headers->set('Content-Type', 'text/plain');
        $response->headers->set('Content-Disposition', $disposition);

        return $response;

    }

    public function brochureAction($id)
    {
        $request = $this->getRequest();
        $id = $request->get($this->admin->getIdParameter());

        $inscirption = $this->admin->getObject($id);

        $company = $inscirption->getCompany();

        if (!$company) {
            throw new NotFoundHttpException(sprintf('Impossible de trouver la fiche entreprise avec l\'id: %s', $id));
        }


        $latexer = $this->get('jobinge.admin.latex');
        $latexer->escaper();

        $fileContent = $this->renderView('@JOBINGEEntreprises/brochure/model.tex.twig', array(
            'company' => $company,

        )); // the generated file content
        $response = new Response($fileContent);

        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $this->createSlug($company->getNom()) . '.tex'
        );

        $response->headers->set('Content-Type', 'text/plain');
        $response->headers->set('Content-Disposition', $disposition);

        return $response;

    }

    public static function createSlug($str, $delimiter = '-')
    {

        $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
        return $slug;

    }

}
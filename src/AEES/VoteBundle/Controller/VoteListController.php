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

namespace AEES\VoteBundle\Controller;


use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class VoteListController extends CRUDController
{

    public function statusAction($id)
    {

        $request = $this->getRequest();
        $id = $request->get($this->admin->getIdParameter());

        $object = $this->admin->getObject($id);


        if (!$object) {
            throw new NotFoundHttpException(sprintf('Impossible de trouver la liste avec l\'id: %s'), $id);
        }

        $em = $this->getDoctrine()->getManager();


        if ($object->getStatus() == 0) {
            $vl = $em->getRepository('AEESVoteBundle:VoteList')->find($id);


            $vp = $em->getRepository('AEESVoteBundle:VotePeople');


            $vl->setStatus(1);
            $vl->setMaxVotes($vp->SumOfVotes($vl->getSession()->getId()));

            $em->persist($vl);
            $em->flush();
        } elseif ($object->getStatus() == 1) {
            $vl = $em->getRepository('AEESVoteBundle:VoteList')->find($id);
            $vl->setStatus(2);

            $em->persist($vl);
            $em->flush();

        }

        return new RedirectResponse($this->admin->generateUrl('list'));
    }
}
<?php

namespace AEES\VoteBundle\Controller;

use AEES\VoteBundle\Entity\VoteListAnswer;
use AEES\VoteBundle\Form\VoteListType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $user = $this->getUser();

        $vs = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AEESVoteBundle:VoteSession')
            ->listByInscription($user->getId());

        return $this->render('AEESVoteBundle:Default:index.html.twig', array('sessions' => $vs));
    }

    public function sessionAction($id)
    {
        if (!$this->isGrantedtoSession($this->getUser()->getId(), $id)) {
            return $this->redirectToRoute('aees_vote_index');
        }

        $vs = $this->getDoctrine()->getManager()->getRepository('AEESVoteBundle:VoteSession')->find($id);

        $vl = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AEESVoteBundle:VoteList')
            ->listBySession($id);

        return $this->render('AEESVoteBundle:Default:session.html.twig', array('lists' => $vl, 'session' => $vs));
    }

    private function isGrantedtoSession($user, $session)
    {
        $vp = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AEESVoteBundle:VotePeople')
            ->isGranted($user, $session);

        if ($vp != 0) {
            return True;
        } else {
            return False;
        }
    }

    public function listAction($id, Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $vl = $em->getRepository('AEESVoteBundle:VoteList')->find($id);

        if (!$vl) {
            return $this->redirectToRoute('aees_vote_index');
        }

        $sessionId = $vl->getSession()->getId();

        if (!$this->isGrantedToList($user->getId(), $id)) {
            return $this->redirectToRoute('aees_vote_session', array('id' => $sessionId));
        }


        $vlc = $em->getRepository('AEESVoteBundle:VoteListChoice');


        $vp = $em->getRepository('AEESVoteBundle:VotePeople');

        $maxVotes = $vp->numberOfVotes($user->getId(), $sessionId);

        $list = $vlc->listByList($id);


        $form = $this->get('form.factory')->create(VoteListType::class, null, array(
            'vlc' => $list,
            'maxVotes' => $maxVotes,
            'action' => $this->generateUrl('aees_vote_list', array('id' => $id)),
            'method' => 'POST'
        ));

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                if (array_sum($form->getData()) != $maxVotes) {
                    $this
                        ->addFlash('success',
                            'Vous avez utilisé ' . array_sum($form->getData()) . ' voix alors que vous en avez ' . $maxVotes . '. Veuillez repondre correctement pour valider votre vote');
                } else {
                    foreach ($form->getData() as $key => $choice) {
                        if ($choice != 0) {
                            $vlc->increaseResult($key, $choice);
                        }

                    }
                    $vla = new VoteListAnswer();


                    $vla->setUser($user);
                    $vla->setList($em->find('AEESVoteBundle:VoteList', $id));


                    $em->persist($vla);

                    $em->flush();


                    return $this->redirectToRoute('aees_vote_session', array('id' => $sessionId));
                }
            }


        }


        return $this->render('AEESVoteBundle:Default:list.html.twig', array('form' => $form->createView(), 'list' => $vl));
    }

    private function isGrantedToList($user, $list)
    {
        $vla = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AEESVoteBundle:VoteListAnswer')
            ->hasVoted($user, $list);

        if ($vla == 0) {
            return true;
        } else {
            return false;
        }
    }

    public function resultAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $vl = $em->getRepository('AEESVoteBundle:VoteList')->find($id);

        if (!$vl) {
            throw new NotFoundHttpException('Pas de resultat disponible');
        }


        $sessionId = $vl->getSession()->getId();

        $vlc = $em->getRepository('AEESVoteBundle:VoteListChoice');

        $totalVotes = $vlc->totalDeVotes($vl->getId());

        $list = $vlc->listByList($id);

        return $this->render('@AEESVote/Default/result.html.twig', array('vl' => $vl, 'choices' => $list, 'total' => $totalVotes));
    }

}

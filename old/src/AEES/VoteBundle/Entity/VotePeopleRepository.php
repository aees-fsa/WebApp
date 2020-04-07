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

namespace AEES\VoteBundle\Entity;


use Doctrine\ORM\EntityRepository;

class VotePeopleRepository extends EntityRepository
{
    public function isGranted($user, $session)
    {
        $qb = $this->createQueryBuilder('vp');

        $qb
            ->select('COUNT(vp.id)')
            ->where('vp.session = :session')
            ->setParameter('session', $session)
            ->andWhere('vp.user = :user')
            ->setParameter('user', $user);

        return $qb
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function numberOfVotes($user, $session)
    {
        $qb = $this->createQueryBuilder('vp');

        $qb
            ->select('vp.max_votes')
            ->where('vp.session = :session')
            ->setParameter('session', $session)
            ->andWhere('vp.user = :user')
            ->setParameter('user', $user);

        return $qb
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function SumOfVotes($sessionId)
    {
        $qb = $this->createQueryBuilder('vp');

        $qb
            ->select('SUM(vp.max_votes)')
            ->where('vp.session = :session')
            ->setParameter('session', $sessionId);

        return $qb
            ->getQuery()
            ->getSingleScalarResult();
    }
}
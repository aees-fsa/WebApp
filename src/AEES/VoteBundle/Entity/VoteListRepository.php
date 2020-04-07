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

class VoteListRepository extends EntityRepository
{
    public function listBySession($session)
    {


        $qb = $this->createQueryBuilder('vl');

        $qb
            ->where('vl.status = 1')
            ->andWhere('vl.session = :session')
            ->setParameter('session', $session);

        return $qb
            ->getQuery()
            ->getResult();
    }

    public function hasAnswer($user, $list)
    {
        $qb = $this->createQueryBuilder('vl');

    }
}
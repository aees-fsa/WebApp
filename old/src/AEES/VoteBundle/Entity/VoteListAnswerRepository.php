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

class VoteListAnswerRepository extends EntityRepository
{
    public function hasVoted($user, $list)
    {
        $qb = $this->createQueryBuilder('vla');

        $qb
            ->select('COUNT(vla.id)')
            ->where('vla.list = :list')
            ->setParameter('list', $list)
            ->andWhere('vla.user = :user')
            ->setParameter('user', $user);

        return $qb
            ->getQuery()
            ->getSingleScalarResult();
    }

}
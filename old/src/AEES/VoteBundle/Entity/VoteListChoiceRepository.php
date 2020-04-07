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

class VoteListChoiceRepository extends EntityRepository
{
    public function listByList($list)
    {
        $qb = $this->createQueryBuilder('vlc');

        $qb
            ->where('vlc.list = :list')
            ->setParameter('list', $list);

        return $qb
            ->getQuery()
            ->getResult();
    }

    public function increaseResult($id, $number)
    {
        $qb = $this->createQueryBuilder('vlc');

        $qb
            ->update($this->getEntityName(), 'vlc')
            ->set('vlc.result', 'vlc.result + :increase')
            ->where('vlc.id = :id')
            ->setParameter(':increase', $number)
            ->setParameter('id', $id);

        return $qb
            ->getQuery()
            ->getResult();
    }

    public function totalDeVotes($listId)
    {
        $qb = $this->createQueryBuilder('vlc');

        $qb
            ->select('SUM(vlc.result)')
            ->where('vlc.list = :list')
            ->setParameter('list', $listId);

        return $qb
            ->getQuery()
            ->getSingleScalarResult();
    }
}
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

namespace JOBINGE\ForumBundle\Entity;

use Doctrine\ORM\EntityRepository;

class InscriptionRepository extends EntityRepository
{
    public function isInscrit($company, $forum)
    {
        $qb = $this->createQueryBuilder('i');

        $qb
            ->select('COUNT(i.id)')
            ->where('i.forum = ?1')
            ->andWhere('i.company = ?2')
            ->setParameter(1, $forum)
            ->setParameter(2, $company);

        if ($qb->getQuery()->getSingleScalarResult() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getActualInscription($company, $forum)
    {
        $qb = $this->createQueryBuilder('i');

        $qb
            ->where('i.forum = ?1')
            ->andWhere('i.company = ?2')
            ->setParameter(1, $forum)
            ->setParameter(2, $company);

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function getAllActiveInscriptions()
    {
        $qb = $this->createQueryBuilder('i');

        $qb
            ->join('i.forum', 'f')
            ->join('i.company', 'c')
            ->where('f.active = true')
            ->andWhere('i.status = 3 OR i.status = 4');

        return $qb->getQuery()->getResult();
    }
}
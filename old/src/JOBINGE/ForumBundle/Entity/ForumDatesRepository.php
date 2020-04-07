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


class ForumDatesRepository extends EntityRepository
{
    public function getAcceptedInscriptionsByDate($date)
    {
        $qb = $this->createQueryBuilder('fd');

        $qb
            ->leftJoin('fd.insciptions', 'i')
            ->leftJoin('i.company', 'c')
            ->where('fd.date = :date')
            ->andWhere('i.status = 3 OR i.status = 4')
            ->setParameter('date', $date)
            ->orderBy('c.nom');

        return $qb->getQuery()->getResult();
    }

}
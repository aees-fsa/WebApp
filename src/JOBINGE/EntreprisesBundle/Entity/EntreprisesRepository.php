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

namespace JOBINGE\EntreprisesBundle\Entity;

use Doctrine\ORM\EntityRepository;

class EntreprisesRepository extends EntityRepository
{
    public function getByContact($user)
    {
        $qb = $this->createQueryBuilder('e');

        $qb->where('e.contact = ?1 ')
            ->setParameter(1, $user);

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function getAllInscfiptions()
    {
        $qb = $this->createQueryBuilder('e');


    }

    public function getEntreprisesByDayAccepted($date)
    {
        $qb = $this->createQueryBuilder('entreprises');

        $qb
            ->join('entreprises.inscriptions', 'inscriptions')
            ->join('inscriptions.dates', 'dates')
            ->where('dates.date = :date')
            ->andWhere('inscriptions.status = 3 OR inscriptions.status = 4')
            ->setParameter('date', $date)
            ->orderBy('entreprises.nom');

        return $qb->getQuery()->getResult();

    }
}
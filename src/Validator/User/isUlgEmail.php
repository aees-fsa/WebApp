<?php
/**
 * Copyright (C) 2020 Andrew SASSOYE
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Affero General Public License as
 *  published by the Free Software Foundation, version 3.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Affero General Public License for more details.
 *
 *  You should have received a copy of the GNU Affero General Public License
 *  along with this program.  If not, see <https://www.gnu.org/licenses/>.
 *
 */

namespace App\Validator\User;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class isUlgEmail extends Constraint
{
    public $message = '"{{ string }}" n\'est pas une adresse mail @student.uliege.be ';

    public function validatedBy()
    {
        return get_class($this) . 'Validator';
    }

}
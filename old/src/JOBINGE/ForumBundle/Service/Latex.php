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

namespace JOBINGE\ForumBundle\Service;


class Latex
{

    // Get the global params
    public function __construct($twig)
    {
        $this->twig = $twig;
    }

    public function escaper()
    {
        $twig = $this->twig;
        $twig->getExtension('Twig_Extension_Core')->setEscaper('latex',
            function ($twig, $string, $charset) {

                // Try to replace HTML entities
                preg_match_all('/&[a-zA-Z]+;/iu', $string, $matches);
                foreach ($matches[0] as $match) {
                    $string = str_replace($match, $this->htmlCodes[$match], $string);
                }

                // Special characters
                $string = str_replace('&sup2;', '\\textsuperscript{2}', $string);
                $string = str_replace('&sup3;', '\\textsuperscript{3}', $string);
                $string = str_replace('²', '\\textsuperscript{2}', $string);
                $string = str_replace('³', '\\textsuperscript{3}', $string);

                // Remove remaining HTML entities
                $string = preg_replace('/&[a-zA-Z]+;/iu', '', $string);

                // Adjust known characters
                $string = str_replace("ä", "\\\"a", $string);
                $string = str_replace("á", "\\'a", $string);
                $string = str_replace("à", "\\`a", $string);
                $string = str_replace("Ä", "\\\"A", $string);
                $string = str_replace("Á", "\\'A", $string);
                $string = str_replace("À", "\\`A", $string);

                $string = str_replace("ë", "\\\"e", $string);
                $string = str_replace("é", "\\'e", $string);
                $string = str_replace("è", "\\`e", $string);
                $string = str_replace("ê", "\\^e", $string);
                $string = str_replace("Ë", "\\\"E", $string);
                $string = str_replace("É", "\\'E", $string);
                $string = str_replace("È", "\\`E", $string);
                $string = str_replace("Ê", "\\^E", $string);

                $string = str_replace("ï", "\\\"i", $string);
                $string = str_replace("í", "\\'i", $string);
                $string = str_replace("ì", "\\`i", $string);
                $string = str_replace("Ï", "\\\"I", $string);
                $string = str_replace("Í", "\\'I", $string);
                $string = str_replace("Ì", "\\`I", $string);

                $string = str_replace("ö", "\\\"o", $string);
                $string = str_replace("ó", "\\'o", $string);
                $string = str_replace("ò", "\\`o", $string);
                $string = str_replace("Ö", "\\\"O", $string);
                $string = str_replace("Ó", "\\'O", $string);
                $string = str_replace("Ò", "\\`O", $string);
                $string = str_replace("õ", "\\~O", $string);
                $string = str_replace("Õ", "\\~O", $string);

                $string = str_replace("ü", "\\\"u", $string);
                $string = str_replace("ú", "\\'u", $string);
                $string = str_replace("ù", "\\`u", $string);
                $string = str_replace("Ü", "\\\"U", $string);
                $string = str_replace("Ú", "\\'U", $string);
                $string = str_replace("Ù", "\\`U", $string);

                $string = str_replace("ñ", "\\~n", $string);
                $string = str_replace("ß", "{\\ss}", $string);
                $string = str_replace("ç", "\\c{c}", $string);
                $string = str_replace("Ç", "\\c{C}", $string);
                $string = str_replace("ș", "\\c{s}", $string);
                $string = str_replace("Ș", "\\c{S}", $string);
                $string = str_replace("ŭ", "\\u{u}", $string);
                $string = str_replace("Ŭ", "\\u{U}", $string);
                $string = str_replace("ă", "\\u{a}", $string);
                $string = str_replace("Ă", "\\u{A}", $string);
                $string = str_replace("ă", "\\v{a}", $string);
                $string = str_replace("Ă", "\\v{A}", $string);
                $string = str_replace("š", "\\v{s}", $string);
                $string = str_replace("Š", "\\v{S}", $string);
                $string = str_replace("Ø", "{\\O}", $string);
                $string = str_replace("ø", "{\\o}", $string);

                // Remaining special characters (cannot be placed with the others,
                // as then the html entity replace would fail).
                $string = str_replace("#", "\\#", $string);
                $string = str_replace("_", "\\_", $string);
                $string = str_replace("^", "\\^{}", $string);
                $string = str_replace("°", "\$^{\\circ}\$", $string);
                $string = str_replace(">", "\\textgreater ", $string);
                $string = str_replace("<", "\\textless ", $string);
                $string = str_replace("~", "\\textasciitilde ", $string);

                // Check for & characters. Inside a tabular(x) env they should not be replaced
                $offset = 0;
                while (FALSE !== ($position = strpos($string, '&', $offset))) {
                    if (!(strrpos($string, '\begin{tabular', $position - strlen($string)) < $position
                        && strpos($string, '\end{tabular', $position) > $position)
                    ) {
                        $string = substr_replace($string, '\\&', $position, 1);
                        $position = $position + 3;
                    }
                    $offset = $position + 1;
                    if ($offset > strlen($string)) {
                        break;
                    }
                }

                return $string;

            }
        );
    }

}
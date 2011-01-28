<?php
/**
 * phploc
 *
 * Copyright (c) 2009-2011, Sebastian Bergmann <sb@sebastian-bergmann.de>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Sebastian Bergmann nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package   phploc
 * @author    Sebastian Bergmann <sb@sebastian-bergmann.de>
 * @copyright 2009-2011 Sebastian Bergmann <sb@sebastian-bergmann.de>
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @since     File available since Release 1.6.0
 */

/**
 * A CSV ResultPrinter for the TextUI.
 *
 * @author    Sebastian Bergmann <sb@sebastian-bergmann.de>
 * @copyright 2009-2011 Sebastian Bergmann <sb@sebastian-bergmann.de>
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: @package_version@
 * @link      http://github.com/sebastianbergmann/phploc/tree
 * @since     Class available since Release 1.6.0
 */
class PHPLOC_TextUI_ResultPrinter_CSV
{
    /**
     * Prints a result set.
     *
     * @param string $filename
     * @param array  $count
     */
    public function printResult($filename, array $count, $keepUnlabeled = false)
    {
        $labels = array(
            'directories'           => 'Directories',
            'files'                 => 'Files',
            'loc'                   => 'Lines of Code (LOC)',
            'ccnByLoc'              => 'Cyclomatic Complexity / Lines of Code',
            'cloc'                  => 'Comment Lines of Code (CLOC)',
            'ncloc'                 => 'Non-Comment Lines of Code (NCLOC)',
            'namespaces'            => 'Namespaces',
            'interfaces'            => 'Interfaces',
            'classes'               => 'Classes',
            'abstractClasses'       => 'Abstract Classes',
            'concreteClasses'       => 'Concrete Classes',
            'nclocByNoc'            => 'Average Class Length (NCLOC)',
            'methods'               => 'Methods',
            'nonStaticMethods'      => 'Non-Static Methods',
            'staticMethods'         => 'Static Methods',
            'publicMethods'         => 'Public Methods',
            'nonPublicMethods'      => 'Non-Public Methods',
            'nclocByNom'            => 'Average Method Length (NCLOC)',
            'ccnByNom'              => 'Cyclomatic Complexity / Number of Methods',
            'anonymousFunctions'    => 'Anonymous Functions',
            'functions'             => 'Functions',
            'constants'             => 'Constants',
            'globalConstants'       => 'Global Constants',
            'classConstants'        => 'Class Constants',
            'eloc'                  => 'Executable Lines of Code (ELOC)',
            'testClasses'           => 'Test Clases',
            'testMethods'           => 'Test Methods',
        );

        // Values reported were no label was defined
        $missingLabels = array_diff_key($count, $labels);

        if ($keepUnlabeled){ // Adds the missing labels
            array_walk($missingLabels, function(&$label, $key) { $label = $key; });
            $labels = array_merge($labels, $missingLabels);
        } else { // Removes the counts without label
            $count = array_diff_key($count, $missingLabels);
        }

        $usedLabels = array_intersect_key($labels, $count);
        $result = array_merge($usedLabels, $count);

        file_put_contents(
          $filename, implode(',', array_keys($result)) . PHP_EOL . implode(',', $result)
        );
    }
}

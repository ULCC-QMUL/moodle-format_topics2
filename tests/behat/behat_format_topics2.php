<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Behat course-related steps definitions.
 *
 * @package    format_topics2
 * @category   test
 * @copyright  2020 Matthias Opitz
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// NOTE: no MOODLE_INTERNAL test here, this file may be required by behat before including /config.php.

//require_once(__DIR__ . '/../../../../../lib/behat/behat_base.php');
require_once(__DIR__ . '/../../../../../course/tests/behat/behat_course.php');

/**
 * Steps definitions related with putting sections under tabs.
 *
 * @copyright 2020 Matthias Opitz
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class behat_format_topics2 extends behat_course {

    /**
     * Moves the current section to the specified tab. You need to be in the course page and on editing mode.
     *
     * @Given /^I move section "(?P<sectionnumber_string>(?:[^"]|\\")*)" to tab "(?P<tabnumber_string>(?:[^"]|\\")*)"$/
     * @param string $sectionnumber
     * @param string $tabnumber
     */
    public function i_move_section_to_tab($sectionnumber, $tabnumber) {
        // Ensures the section exists.
        $xpath = $this->section_exists($sectionnumber);
        $strtotab = get_string('totab', 'format_topics2');

        // If javascript is on, link is inside a menu.
        if ($this->running_javascript()) {
            $this->i_open_section_edit_menu($sectionnumber);
        }

        // Click on move to tab link.
        $this->execute('behat_general::i_click_on_in_the',
            array($strtotab.$tabnumber, "link", $this->escape($xpath), "xpath_element")
        );

        if ($this->running_javascript()) {
            $this->getSession()->wait(self::get_timeout() * 1000, self::PAGE_READY_JS);
            $this->i_wait_until_section_is_available($sectionnumber);
        }
    }


}
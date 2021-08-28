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
 * The mod_cpdlogbook entry_created event.
 *
 * @package mod_cpdlogbook
 * @copyright 2021 Jordan Shatte <jsha773@hotmail.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_cpdlogbook\event;

/**
 * Class entry_viewed
 *
 * @package mod_cpdlogbook
 */
class entry_viewed extends entry_created {

    /**
     * Sets the crud data for the event
     */
    public function init() {
        parent::init();
        $this->data['crud'] = 'r';
    }

    /**
     * Returns the description of the event.
     *
     * @return string
     */
    public function get_description() {
        $a = new \stdClass();
        $a->userid = $this->get_data()['userid'];
        $a->entryid = $this->get_data()['objectid'];
        $a->name = $this->get_data()['other']['entryname'];

        return "The user with id '{$a->userid}' viewed the '{$a->name}' cpdlogbook entry with id '{$a->entryid}'.";
    }
}

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
 * The mod_cpdlogbook edit_entry form.
 *
 * @package mod_cpdlogbook
 * @copyright 2021 Jordan Shatte <jsha773@hotmail.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_cpdlogbook\form;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/formslib.php');

/**
 * Class edit_entry
 *
 * @package mod_cpdlogbook
 */
class edit_entry extends \moodleform {

    /**
     * The definition of the form. Used to add elements and rules to the form.
     *
     * @throws \coding_exception
     */
    public function definition() {
        $mform = $this->_form;

        $mform->addElement('text', 'name', get_string('name', 'mod_cpdlogbook'));
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', null, 'required', null, 'client');

        $mform->addElement('date_selector', 'completiondate', get_string('completiondate', 'mod_cpdlogbook'));
        $mform->addRule('completiondate', null, 'required', null, 'client');
        $mform->setType('completiondate', PARAM_INT);

        $mform->addElement('float', 'points', get_string('points', 'mod_cpdlogbook'), ['size' => '4']);
        $mform->addRule('points', null, 'required', null, 'client');
        $mform->setType('points', PARAM_INT);

        $mform->addElement('duration', 'hours', get_string('duration', 'mod_cpdlogbook'), ['optional' => false]);
        $mform->setDefault('hours', HOURSECS);
        $mform->setType('hours', PARAM_INT);

        $mform->addElement('text', 'provider', get_string('provider', 'mod_cpdlogbook'));
        $mform->setType('provider', PARAM_TEXT);

        $mform->addElement('text', 'location', get_string('location', 'mod_cpdlogbook'));
        $mform->setType('location', PARAM_TEXT);

        $mform->addElement('textarea', 'summary', get_string('summary', 'mod_cpdlogbook'),
            ['rows' => '5', 'cols' => '50']);
        $mform->setType('summary', PARAM_TEXT);

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('hidden', 'create');
        $mform->setType('create', PARAM_BOOL);

        $mform->addElement('hidden', 'fromdetails');
        $mform->setType('fromdetails', PARAM_BOOL);

        $this->add_action_buttons();
    }

}

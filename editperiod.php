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
 * Edit page. Used to edit and create periods.
 *
 * @package mod_cpdlogbook
 * @copyright 2021 Jordan Shatte <jsha773@hotmail.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use mod_cpdlogbook\form\edit_period;
use mod_cpdlogbook\persistent\period;

require_once('../../config.php');

// Get the course module id and the entry id from either the parameters or the hidden fields.
$id = required_param('id', PARAM_INT);
$create = required_param('create', PARAM_BOOL);

if ($create) {
    // If an entry is being created.
    $record = new stdClass();
    $record->id = $id;

    list ($course, $cm) = get_course_and_cm_from_cmid($id, 'cpdlogbook');

    // If an existing entry is being edited.
    require_course_login($course, false, $cm);
} else {
    // If the entry doesn't exist.
    $record = (new period($id))->to_record();

    // If the cpdlogbook doesn't exist.
    $cpdlogbook = $DB->get_record('cpdlogbook', ['id' => $record->cpdlogbookid], '*', MUST_EXIST);

    // Get the course module from the cpdlogbook instance.
    $cm = get_coursemodule_from_instance('cpdlogbook', $cpdlogbook->id, $cpdlogbook->course);

    require_course_login($cpdlogbook->course, false, $cm);
}

$context = context_module::instance($cm->id);

$mform = new edit_period();


$url = new moodle_url('/mod/cpdlogbook/periods.php', ['id' => $cm->id]);

if ($mform->is_cancelled()) {
    redirect($url);
} else if ($fromform = $mform->get_data()) {
    unset($fromform->create);
    unset($fromform->submitbutton);

    if ($create) {
        unset($fromform->id);

        $fromform->cpdlogbookid = $cm->instance;

        $newperiod = new period(0, $fromform);
        $newperiod->create();
    } else {
        // Update the record according to the submitted form data.
        $newperiod = new period($fromform->id, $fromform);
        $newperiod->update();
    }

    redirect($url);
}

$PAGE->set_url(new moodle_url('/mod/cpdlogbook/periods.php', [ 'id' => $id, 'create' => $create ]));

// Set the title according to if an entry is being created or updated.
if ($create) {
    $title = get_string('createtitle', 'mod_cpdlogbook');
} else {
    $title = get_string('edit');
}

$PAGE->set_title($title);
$PAGE->set_heading($title);
$PAGE->navbar->add($title);

echo $OUTPUT->header();
echo $OUTPUT->heading($title);

$record->create = $create;
$mform->set_data($record);
$mform->display();

echo $OUTPUT->footer();
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

require_once('../../config.php');

$cmid = required_param('cmid', PARAM_INT);
$id = required_param('id', PARAM_INT);

list ($course, $cm) = get_course_and_cm_from_cmid($cmid, 'cpdlogbook');

require_course_login($course, false, $cm);

require_sesskey();

// If the cpdlogbook doesn't exist.
if (! $cpdlogbook = $DB->get_record('cpdlogbook', ['id' => $cm->instance])) {
    throw new moodle_exception('invalidentry');
}

// If the entry either doesn't exist OR it doesn't match this cmid.
if (! $DB->get_record('cpdlogbook_entries', ['id' => $id, 'cpdlogbookid' => $cpdlogbook->id, 'userid' => $USER->id])) {
    throw new moodle_exception('invalidentry');
}

// From here, we can be sure that the entry exists, and is associated with the current user and the cpdlogbook.
$DB->delete_records('cpdlogbook_entries', ['id' => $id, 'cpdlogbookid' => $cpdlogbook->id, 'userid' => $USER->id]);
redirect(new moodle_url('/mod/cpdlogbook/view.php', ['id' => $cmid]));

<?php
/**
 * This file is part of Moodle - http://moodle.org/
 *
 * Moodle is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Moodle is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 *
 * @category  Abstract
 * @package   Core_Calendar
 * @author    Shubhangee Verma <shubhv92@gmail.com>
 * @copyright 2014 Shubhangee Verma <shubhv92@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @link      www.moodle.org
 */

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/calendar/lib.php');


/**
 * Calendar library tests.
 *
 * @package    core_calendar
 * @category   phpunit
 * @copyright  2014 Shubhangee Verma {@link }
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class core_calendar_calendarlib_testcase extends advanced_testcase {

	public function test_calendar_update_subscription() {
        $this->resetAfterTest(true);

        $subscription = new stdClass();
        $subscription->eventtype = 'site';
        $subscription->name = 'test';
        $id = calendar_add_subscription($subscription);

        $subscription = new stdClass();
        $subscription->id = $id;
        $subscription->name = 'awesome';
        calendar_update_subscription($subscription);
        $sub = calendar_get_subscription($id);
        $this->assertEquals($subscription->name, $sub->name);

        $subscription = new stdClass();
        $subscription->id = $id;
        $subscription->name = 'awesome2';
        $subscription->pollinterval = 604800;
        calendar_update_subscription($subscription);
        $sub = calendar_get_subscription($id);
        $this->assertEquals($subscription->name, $sub->name);
        $this->assertEquals($subscription->pollinterval, $sub->pollinterval);

        $subscription = new stdClass();
        $subscription->name = 'awesome4';
        $this->setExpectedException('coding_exception');
        calendar_update_subscription($subscription);
    }
	
    public function test_calendar_add_subscription() {
		global $DB;
		
        $this->resetAfterTest(true);

        $subscription = new stdClass();
        $subscription->contextid = context_system::instance()->id;
        $subscription->name = 'test subscription';
        $subscription->idnumber = 'testid';
        $subscription->description = 'test subscription desc';
        $subscription->descriptionformat = FORMAT_HTML;

        $id = calendar_add_subscription($subscription);
        $this->assertNotEmpty($id);

        $newsubscription = $DB->get_record('event_subscriptions', array('id'=>$id));
        $this->assertEquals($subscription->contextid, $newsubscription->contextid);
        $this->assertSame($subscription->name, $newsubscription->name);
        $this->assertSame($subscription->description, $newsubscription->description);
        $this->assertEquals($subscription->descriptionformat, $newsubscription->descriptionformat);
        $this->assertNotEmpty($newsubscription->timecreated);
        $this->assertSame($newsubscription->component, '');
        $this->assertSame($newsubscription->timecreated, $newsubscription->timemodified);
    }

    public function test_calendar_delete_subscription() {
        global $DB;

        $this->resetAfterTest();

		$subscription = new stdClass();
        $subscription->contextid = context_system::instance()->id;
        $subscription->name = 'test subscription';
        $subscription->idnumber = 'testid';
        $subscription->description = 'test subscription desc';
        $subscription->descriptionformat = FORMAT_HTML;
        $id = calendar_add_subscription($subscription);

        calendar_delete_subscription($subscription);

        $this->assertFalse($DB->record_exists('event_subscriptions', array('id'=>$subscription->id)));
    }
}

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
 * @package   Core
 * @author    Shubhangee Verma <shubhv92@gmail.com>
 * @copyright 2014 Shubhangee Verma <shubhv92@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @link      www.moodle.org
 */

/**
 * Calendar subscription deleted event.
 *
 * @package   core
 * @copyright 2014 Shubhangee Verma <shubhv92@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core\event;

defined('MOODLE_INTERNAL') || die();

/**
 * Calendar subscription deleted class.
 *
 * @category  Abstract
 * @package   Core
 * @author    Shubhangee Verma <shubhv92@gmail.com>
 * @copyright 2014 Shubhangee Verma <shubhv92@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @link      www.moodle.org
 */
class Calendar_Subscription_Deleted extends base
{

    /**
     * Init method.
     *
     * @return void
     */
    protected function init()
    {
        $this->data['crud'] = 'd';
        $this->data['edulevel'] = self::LEVEL_OTHER;
        $this->data['objecttable'] = 'event';
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function getName()
    {
        return get_string('eventsubscriptiondeleted', 'calendar');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function getDescription()
    {
        return "User {$this->userid} has deleted a calendar
         subscription with id {$this->objectid}.";
    }

    /**
     * Returns relevant URL.
     *
     * @return \moodle_url
     */
    public function getUrl()
    {
        return new \moodle_url(
            'calendar/delete.php'
        );
    }
}

<?php /* $Id$ $URL$ */
if (!defined('W2P_BASE_DIR')) {
	die('You should not access this file directly.');
}

global $AppUI, $company_id, $deny, $canRead, $canEdit, $w2Pconfig, $start_date, $end_date, $this_day, $event_filter, $event_filter_list;
require_once $AppUI->getModuleClass('calendar');

$perms = &$AppUI->acl();
$user_id = $AppUI->user_id;
$other_users = false;
$no_modify = false;

$start_date = new CDate('0000-00-00 00:00:00');
$end_date = new CDate('9999-12-31 23:59:59');

// assemble the links for the events
$events = CEvent::getEventsForPeriod($start_date, $end_date, 'all', 0, 0, $company_id);

$start_hour = w2PgetConfig('cal_day_start');
$end_hour = w2PgetConfig('cal_day_end');

$tf = $AppUI->getPref('TIMEFORMAT');
$df = $AppUI->getPref('SHDATEFORMAT');
$types = w2PgetSysVal('EventType');

$html = '<table cellspacing="1" cellpadding="2" border="0" width="100%" class="tbl">';
$html .= '<tr><th>' . $AppUI->_('Date') . '</th><th>' . $AppUI->_('Type') . '</th><th>' . $AppUI->_('Event') . '</th></tr>';
foreach ($events as $row) {
	$html .= '<tr>';
	$start = new CDate($row['event_start_date']);
	$end = new CDate($row['event_end_date']);
	$html .= '<td width="25%" nowrap="nowrap">' . $start->format($df . ' ' . $tf) . '&nbsp;-&nbsp;';
	$html .= $end->format($df . ' ' . $tf) . '</td>';

	$href = '?m=calendar&a=view&event_id=' . $row['event_id'];
	$alt = $row['event_description'];

	$html .= '<td width="10%" nowrap="nowrap">';
	$html .= w2PshowImage('event' . $row['event_type'] . '.png', 16, 16, '', '', 'calendar');
	$html .= '&nbsp;<b>' . $AppUI->_($types[$row['event_type']]) . '</b><td>';
	$html .= $href ? '<a href="' . $href . '" class="event" title="' . $alt . '">' : '';
	$html .= $row['event_title'];
	$html .= $href ? '</a>' : '';
	$html .= '</td></tr>';
}
$html .= '</table>';
echo $html;
?>
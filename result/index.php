<?php
/**
 * Mahara: Electronic portfolio, weblog, result builder and social networking
 * Copyright (C) 2006-2009 Catalyst IT Ltd and others; see:
 *                         http://wiki.mahara.org/Contributors
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package    mahara
 * @subpackage artefact-result
 * @author     Asanka
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 *
 */

define('INTERNAL', true);
define('MENUITEM', 'content/results');
define('SECTION_PLUGINTYPE', 'artefact');
define('SECTION_PLUGINNAME', 'results');
define('SECTION_PAGE', 'index');
define('RESULTS_SUBPAGE', 'index');

require_once(dirname(dirname(dirname(__FILE__))) . '/init.php');
define('TITLE', get_string('results', 'artefact.results'));
require_once('pieforms/pieform.php');
safe_require('artefact', 'results');

/*$defaults = array(
    'coverletter' => array(
        'default' => '',
        'fshelp' => true,
    ),
);*/
//$coverletterform = pieform(simple_resumefield_app($defaults, 'artefact/results/index.php'));

// load up all the artefacts this user already has....
$firstsemester = null;
try {
    $firstsemester = artefact_instance_from_type('firstsemester');
}
catch (Exception $e) { }

$firstsemester = pieform(array(
    'name'        => 'firstsemester',
    'plugintype'  => 'artefact',
    'pluginname'  => 'results',
    'jsform'      => true,
    'method'      => 'post',
    'elements'    => array(
        'firstsemester' => array(
            'type' => 'fieldset',
            'legend' => get_string('firstsemester', 'artefact.results'),
            'elements' => array(
                'semestergpa' => array(
                    'type'       => 'text',
                    /*'caloptions' => array(
                        'showsTime'      => false,
                        'ifFormat'       => get_string('strfdateofbirth', 'langconfig')
                        ),*/
                    'defaultvalue' => ((!empty($firstsemester)) 
                                       ? $firstsemester->get_composite('semestergpa') : null),
                    'title' => get_string('semestergpa', 'artefact.results'),
                    //'description' => get_string('dateofbirthformatguide'),
					'size' => 30,
                ),
                'cumulativegpa' => array(
                    'type' => 'text',
                    'defaultvalue' => ((!empty($firstsemester)) 
                        ? $firstsemester->get_composite('cumulativegpa') : null),
                    'title' => get_string('cumulativegpa', 'artefact.results'),
                    'size' => 30,
                ),  
                /*'citizenship' => array(
                    'type' => 'text',
                    'defaultvalue' => ((!empty($personalinformation))
                        ? $personalinformation->get_composite('citizenship') : null),
                    'title' => get_string('citizenship', 'artefact.resume'),
                    'size' => 30,
                ),
                'visastatus' => array(
                    'type' => 'text', 
                    'defaultvalue' => ((!empty($personalinformation))
                        ? $personalinformation->get_composite('visastatus') : null),
                    'title' => get_string('visastatus', 'artefact.resume'),
                    'help'  => true,
                    'size' => 30,
                ),
                'gender' => array(
                    'type' => 'radio', 
                    'defaultvalue' => ((!empty($personalinformation))
                        ? $personalinformation->get_composite('gender') : null),
                    'options' => array(
                        'female' => get_string('female', 'artefact.resume'),
                        'male'   => get_string('male', 'artefact.resume'),
                    ),
                    'title' => get_string('gender', 'artefact.resume'),
                ),
                'maritalstatus' => array(
                    'type' => 'text',
                    'defaultvalue' => ((!empty($personalinformation))
                        ? $personalinformation->get_composite('maritalstatus') :  null),
                    'title' => get_string('maritalstatus', 'artefact.resume'),
                    'size' => 30,
                ),*/
				
                'save' => array(
                    'type' => 'submit',
                    'value' => get_string('save'),
                ),
            ),
        ),
    ),
));

$smarty = smarty(array('artefact/results/js/simpleresumefield.js'));
//$smarty->assign('coverletterform', $coverletterform);
$smarty->assign('personalinformationform',$personalinformationform);
$smarty->assign('INLINEJAVASCRIPT', '$j(simple_resumefield_init);');
$smarty->assign('PAGEHEADING', TITLE);
$smarty->assign('SUBPAGENAV', PluginArtefactResults::submenu_items());
$smarty->display('artefact:results:index.tpl');

function personalinformation_submit(Pieform $form, $values) {
    global $firstsemester, $USER;
    $userid = $USER->get('id');
    $errors = array();

    try {
        if (empty($firstsemester)) {
            $firstsemester = new ArtefactTypeFirstsemester(0, array(
                'owner' => $userid,
                'title' => get_string('firstsemester', 'artefact.results'),
            ));
        }
        foreach (array_keys(ArtefactTypeFirstsemester::get_composite_fields()) as $field) {
            $firstsemester->set_composite($field, $values[$field]);
        }
        $firstsemester->commit();
    }
    catch (Exception $e) {
        $errors['firstsemester'] = true;
    }

    if (empty($errors)) {
        $form->json_reply(PIEFORM_OK, get_string('resumesaved','artefact.results'));
    }
    else {
        $message = '';
        foreach (array_keys($errors) as $key) {
            $message .= get_string('resumesavefailed', 'artefact.results')."\n";
        }
        $form->json_reply(PIEFORM_ERR, $message);
    }
}

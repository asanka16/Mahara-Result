<?php
/**
 * Mahara: Electronic portfolio, weblog, resume builder and social networking
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
 * @subpackage artefact-resume
 * @author     Catalyst IT Ltd
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 * @copyright  (C) 2006-2009 Catalyst IT Ltd http://catalyst.net.nz
 *
 */

define('INTERNAL', true);
define('MENUITEM', 'content/results');
define('SECTION_PLUGINTYPE', 'artefact');
define('SECTION_PLUGINNAME', 'results');
define('SECTION_PAGE', 'index');
define('RESUME_SUBPAGE', '4thyear1stsem');

require_once(dirname(dirname(dirname(__FILE__))) . '/init.php');
define('TITLE', get_string('results', 'artefact.results'));
require_once('pieforms/pieform.php');
safe_require('artefact', 'results');

$compositetypes = array('8thsemesterresults');
$inlinejs = ArtefactTypeResultsComposite::get_js($compositetypes);
$compositeforms = ArtefactTypeResultsComposite::get_forms($compositetypes);

$smarty = smarty(array('tablerenderer'));
$smarty->assign('compositeforms', $compositeforms);
$smarty->assign('INLINEJAVASCRIPT', $inlinejs);
$smarty->assign('PAGEHEADING', TITLE);
$smarty->assign('SUBPAGENAV', PluginArtefactResults::submenu_items());
$smarty->display('artefact:results:4thyear2ndsem.tpl');

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

defined('INTERNAL') || die();

class PluginArtefactResults extends Plugin {
    
    public static function get_artefact_types() {
        return array(
            '1stsemesterresults', 
            '2ndsemesterresults',
            '3rdsemesterresults',
            '4thsemesterresults',
            '5thsemesterresults',
            '6thsemesterresults',
            '7thsemesterresults',
            '8thsemesterresults',
            
        );
    }
    
    public static function get_block_types() {
        return array(); 
    }

    public static function get_plugin_name() {
        return 'results';
    }

    public static function menu_items() {
        return array(
            'content/results' => array(
                'path' => 'content/results',
                'title' => get_string('results', 'artefact.results'),
                'url' => 'artefact/results/index.php',
                'weight' => 50,
            ),
        );
    }

    public static function get_artefact_type_content_types() {
        return array(
            '1stsemesterresults'   => array('table'),
            '2ndsemesterresults'   => array('table'),
            '3rdsemesterresults'   => array('table'),
            '4thsemesterresults'   => array('table'),
            '5thsemesterresults'   => array('table'),
            '6thsemesterresults'   => array('table'),
            '7thsemesterresults'   => array('table'),
            '8thsemesterresults'   => array('table'),
        );
    }

    public static function submenu_items() {
        $tabs = array(
            'index' => array(
                'page'  => 'index',
                'url'   => 'artefact/results',
                'title' => get_string('1styear1stsem', 'artefact.results'),
            ),
            '1styear2ndsem' => array(
                'page'  => '1styear2ndsem',
                'url'   => 'artefact/results/1styear2ndsem.php',
                'title' => get_string('1styear2ndsem', 'artefact.results'),
            ),
            '2ndyear1stsem' => array(
                'page'  => '2ndyear1stsem',
                'url'   => 'artefact/results/2ndyear1stsem.php',
                'title' => get_string('2ndyear1stsem', 'artefact.results'),
            ),
            '2ndyear2ndsem' => array(
                'page'  => '2ndyear2ndsem',
                'url'   => 'artefact/results/2ndyear2ndsem.php',
                'title' => get_string('2ndyear2ndsem', 'artefact.results'),
            ),
            '3rdyear1stsem' => array(
                'page'  => '3rdyear1stsem',
                'url'   => 'artefact/results/3rdyear1stsem.php',
                'title' => get_string('3rdyear1stsem', 'artefact.results'),
            ),
            '3rdyear2ndsem' => array(
                'page'  => '3rdyear2ndsem',
                'url'   => 'artefact/results/3rdyear2ndsem.php',
                'title' => get_string('3rdyear2ndsem', 'artefact.results'),
            ),
			'4thyear1stsem' => array(
                'page'  => '4thyear1stsem',
                'url'   => 'artefact/results/4thyear1stsem.php',
                'title' => get_string('4thyear1stsem', 'artefact.results'),
            ),
			'4thyear2ndsem' => array(
                'page'  => '4thyear2ndsem',
                'url'   => 'artefact/results/4thyear2ndsem.php',
                'title' => get_string('4thyear2ndsem', 'artefact.results'),
            ),
            'license' => array(
                'page'  => 'license',
                'url'   => 'artefact/results/license.php',
                'title' => get_string('license', 'artefact.results'),
            ),
        );
        if (!get_config('licensemetadata')) {
            unset($tabs['license']);
        }
        if (defined('RESULTS_SUBPAGE') && isset($tabs[RESULTS_SUBPAGE])) {
            $tabs[RESULTS_SUBPAGE]['selected'] = true;
        }
        return $tabs;
    }

    public static function composite_tabs() {
        return array(
            '2ndsemesterresults'  => '1styear2ndsem',
            //'employmenthistory' => '1styear2ndsem',
            'certification'     => '2ndyear1stsem',
            'book'              => '2ndyear1stsem',
            'membership'        => '2ndyear1stsem',
        );
    }
}

class ArtefactTypeResults extends ArtefactType {

    public static function get_icon($options=null) {}

    public function __construct($id=0, $data=array()) {
        if (empty($id)) {
            $data['title'] = get_string($this->get_artefact_type(), 'artefact.results');
        }
        parent::__construct($id, $data);
    }
    
    public static function is_singular() {
        return false;
    }

    public static function format_child_data($artefact, $pluginname) {
        $a = new StdClass;
        $a->id         = $artefact->id;
        $a->isartefact = true;
        $a->title      = '';
        $a->text       = get_string($artefact->artefacttype, 'artefact.results'); // $artefact->title;
        $a->container  = (bool) $artefact->container;
        $a->parent     = $artefact->id;
        return $a;
    }

    public static function get_links($id) {
        // @todo Catalyst IT Ltd
    }

    /**
     * Default render method for resume fields - show their description
     */
    public function render_self($options) {
        return array('html' => clean_html($this->description));
    }

    /**
     * Overrides the default commit to make sure that any 'entireresume' blocks 
     * in views the user have know about this artefact - but only if necessary. 
     * Goals and 3rdyear1stsem are not in the entireresume block
     *
     * @param boolean $updateresumeblocks Whether to update any resume blockinstances
     */
    public function commit() {
        parent::commit();

        if ($blockinstances = get_records_sql_array('
            SELECT id, "view", configdata
            FROM {block_instance}
            WHERE blocktype = \'entireresume\'
            AND "view" IN (
                SELECT id
                FROM {view}
                WHERE "owner" = ?)', array($this->owner))) {
            foreach ($blockinstances as $blockinstance) {
                $whereobject = (object)array(
                    'view' => $blockinstance->view,
                    'artefact' => $this->get('id'),
                    'block' => $blockinstance->id,
                );
                ensure_record_exists('view_artefact', $whereobject, $whereobject);
            }
        }
    }

    public function get_license_artefact() {
        if ($this->get_artefact_type() == 'firstsemester')
            return $this;

        $pi = get_record('artefact',
                         'artefacttype', 'firstsemester',
                         'owner', $this->owner);
        if (!$pi)
            return null;

        require_once(get_config('docroot') . 'artefact/lib.php');
        return artefact_instance_from_id($pi->id);
    }


    public function render_license($options, &$smarty) {
        if (!empty($options['details']) and get_config('licensemetadata')) {
            $smarty->assign('license', render_license($this->get_license_artefact()));
        }
        else {
            $smarty->assign('license', false);
        }
    }
}

/*class ArtefactTypeCoverletter extends ArtefactTypeResults {
    
    public static function is_singular() {
        return true;
    }

    public function __construct($id=0, $data=array()) {
        if (empty($id)) {
            $data['title'] = get_string($this->get_artefact_type(), 'artefact.results');
        }
        parent::__construct($id, $data);
    }

}*/

/*class ArtefactTypeInterest extends ArtefactTypeResults {

    public static function is_singular() {
        return true;
    }

}*/

/*class ArtefactTypeContactinformation extends ArtefactTypeResults {

    public function render_self($options) {
        $smarty = smarty_core();
        $fields = ArtefactTypeContactinformation::get_profile_fields();
        foreach ($fields as $f) {
            try {
                $$f = artefact_instance_from_type($f, $this->get('owner'));
                $rendered = $$f->render_self(array());
                $smarty->assign($f, $rendered['html']);
                $smarty->assign('hascontent', true);
            }
            catch (Exception $e) { }
        }

        $this->render_license($options, $smarty);

        return array('html' => $smarty->fetch('artefact:resume:fragments/contactinformation.tpl'));
    }

    public static function is_singular() {
        return true;
    }

    public static function setup_new($userid) {
        try {
            return artefact_instance_from_type('contactinformation', $userid);
        } catch (ArtefactNotFoundException $e) {
            $artefact = new ArtefactTypeContactinformation(null, array(
                'owner' => $userid,
                'title' => get_string('contactinformation', 'artefact.resume')
            ));
            $artefact->commit();
        }
        return $artefact;
    }

    public static function get_profile_fields() {
        static $fields = array(
            'address', 
            'town',
            'city', 
            'country', 
            'faxnumber',
            'businessnumber',
            'homenumber',
            'mobilenumber'
        );
        return $fields;
    }

}*/

class ArtefactTypeFirstsemester extends ArtefactTypeResults {
    
    protected $composites;

    public function __construct($id=0, $data=null) {
        if (empty($id)) {
            $data['title'] = get_string('firstsemester', 'artefact.results');
        }
        parent::__construct($id, $data);
        $this->composites = ArtefactTypeFirstsemester::get_composite_fields();
        /*if (!empty($id)) {
            $this->composites = (array)get_record('artefact_resume_personal_information', 'artefact', $id,
                null, null, null, null, '*, ' . db_format_tsfield('dateofbirth'));
        }*/
    }

    public function set_composite($field, $value) {
        if (!array_key_exists($field, $this->composites)) {
            throw new InvalidArgumentException("Tried to set a non existant composite, $field");
        }
        if ($this->composites[$field] == $value) {
            return true;
        }
        // only set it to dirty if it's changed
        $this->dirty = true;
        $this->mtime = time();
        $this->composites[$field] = $value;
    }   

    public function get_composite($field) {
        return $this->composites[$field];
    }

    public function commit() {
        if (empty($this->dirty)) {
            return true;
        }

        db_begin(); 

        $data = new StdClass;
        foreach ($this->composites as $field => $value) {
            /*if ($field == 'dateofbirth' && !empty($value)) {
                $value = db_format_timestamp($value);
            }*/
            $data->{$field} = $value;
        }   
        $inserting = empty($this->id);
        parent::commit();
        $data->artefact = $this->id;
        if ($inserting) {
            insert_record('artefact_resume_personal_information', $data);
        }
        else {
            update_record('artefact_resume_personal_information', $data, 'artefact');
        }

        db_commit();
    }

    public static function get_composite_fields() {
        static $composites = array(
            'semestergpa' => null,
            'cumulativegpa' => null, 
            //'citizenship' => null,
            //'visastatus' => null,
           // 'gender' => null,
            //'maritalstatus' => null,
        );
        return $composites;
    }

    public static function is_singular() {
        return true;
    }

    public function render_self($options) {
        $smarty = smarty_core();
        $fields = array();
        foreach (array_keys(ArtefactTypeFirstsemester::get_composite_fields()) as $field) {
            $value = $this->get_composite($field);
            /*if ($field == 'gender' && !empty($value)) {
                $value = get_string($value, 'artefact.resume');
            }
            if ($field == 'dateofbirth' && !empty($value)) {
                $value = format_date($value+3600, 'strftimedate');
            }*/
            $fields[get_string($field, 'artefact.results')] = $value;
        }
        $smarty->assign('fields', $fields);
        $this->render_license($options, $smarty);
        return array('html' => $smarty->fetch('artefact:results:fragments/firstsemester.tpl'));
    }

    public function delete() {
        db_begin();

        delete_records('artefact_resume_personal_information', 'artefact', $this->id);
        parent::delete();

        db_commit();
    }

    public static function bulk_delete($artefactids) {
        if (empty($artefactids)) {
            return;
        }

        $idstr = join(',', array_map('intval', $artefactids));

        db_begin();
        delete_records_select('artefact_resume_personal_information', 'artefact IN (' . $idstr . ')');
        parent::bulk_delete($artefactids);
        db_commit();
    }
}



abstract class ArtefactTypeResultsComposite extends ArtefactTypeResults {

    public static function is_singular() {
        return true;
    }

    public static function get_composite_artefact_types() {
        return array(
            '2ndsemesterresults',
            'eduhistory',
            'certification',
            'book',
            'membership'
        );
    }

    /**
    * This function should return a snippet of javascript
    * to be plugged into a table renderer instantiation
    * it comprises the cell function definition
    */
    public static abstract function get_tablerenderer_js();

    public static abstract function get_tablerenderer_title_js_string();

    public static abstract function get_tablerenderer_body_js_string();

    /**
     * Can be overridden to format data retrieved from artefact tables for 
     * display of the resume artefact by render_self
     */
    public static function format_render_self_data($data) {
        return $data;
    }

    /** 
    * This function should return an array suitable to 
    * put into the 'elements' part of a pieform array
    * to generate a form to add an instance
    */
    public static abstract function get_addform_elements();

    /**
    * This function processes the form for the composite
    * @throws Exception
    */
    public static function process_compositeform(Pieform $form, $values) {
        global $USER;
        self::ensure_composite_value($values, $values['compositetype'], $USER->get('id'));
    }

    /**
     * Ensures that the given value for the given composite is present
     * TODO: expand on these docs.
     */
    public static function ensure_composite_value($values, $compositetype, $owner) {
        if (!in_array($compositetype, self::get_composite_artefact_types())) {
            throw new SystemException("ensure_composite_value called with invalid composite type");
        }
        try {
            $a = artefact_instance_from_type($compositetype, $owner);
            $a->set('mtime', time());
        }
        catch (Exception $e) {
            $classname = generate_artefact_class_name($compositetype);
            $a = new $classname(0, array(
                'owner' => $owner,
                'title' => get_string($compositetype, 'artefact.results'),
                )
            );
        }

        $a->commit();

        $values['artefact'] = $a->get('id');

        $table = 'artefact_results_' . $compositetype;
        if (!empty($values['id'])) {
            update_record($table, (object)$values, 'id');
        }
        else {
            if (isset($values['displayorder'])) {
                $values['displayorder'] = intval($values['displayorder']);
            }
            else {
                $max = get_field($table, 'MAX(displayorder)', 'artefact', $values['artefact']);
                $values['displayorder'] = is_numeric($max) ? $max + 1 : 0;
            }
            insert_record($table, (object)$values);
        }
    }

    public function delete() {
        $table = $this->get_other_table_name();
        db_begin();

        delete_records($table, 'artefact', $this->id);
        parent::delete();

        db_commit();
    }

    public static function bulk_delete_composite($artefactids, $compositetype) {
        $table = 'artefact_results_' . $compositetype;
        if (empty($artefactids)) {
            return;
        }

        $idstr = join(',', array_map('intval', $artefactids));

        db_begin();
        delete_records_select($table, 'artefact IN (' . $idstr . ')');
        parent::bulk_delete($artefactids);
        db_commit();
    }

    /**
    * Takes a pieform that's been set up by all the 
    * subclass get_addform_elements functions
    * and puts the default values in (and hidden id field)
    * ready to be an edit form
    * 
    * @param $form pieform structure (before calling pieform() on it
    * passed by _reference_
    */
    public static function populate_form(&$form, $id, $type) {
        if (!$composite = get_record('artefact_results_' . $type, 'id', $id)) {
            throw new InvalidArgumentException("Couldn't find composite of type $type with id $id");
        }
        $datetypes = array('subjectcode', 'credit');
        foreach ($form['elements'] as $k => $element) {
            if ($k == 'submit' || $k == 'compositetype') {
                continue;
            }
            if (isset($composite->{$k})) {
                $form['elements'][$k]['defaultvalue'] = $composite->{$k};
            }
        }
        $form['elements']['id'] = array(
            'type' => 'hidden',
            'value' => $id,
        );
        $form['elements']['artefact'] = array(
            'type' => 'hidden',
            'value' => $composite->artefact,
        );
    }


    /** 
    * call the parent constructor
    * and then load up the stuff from the supporting table
    */
    public function __construct($id=0, $data=array()) {
        if (empty($id)) {
            $data['container'] = 0;
            $data['title'] = get_string($this->get_artefact_type(), 'artefact.results');
        }
        parent::__construct($id, $data);
    }    

    /** 
    * returns the name of the supporting table
    */
    public function get_other_table_name() {
        return 'artefact_results_' . $this->get_artefact_type();
    }

    public function render_self($options) {
        global $USER;
        $suffix = '_' . substr(md5(microtime()), 0, 4);
        $smarty = smarty_core();
        $smarty->assign('hidetitle', true);
        $smarty->assign('suffix', $suffix);
        $type = $this->get('artefacttype');
        $othertable = 'artefact_resume_' . $type;
        $owner = $USER->get('id');

        $sql = 'SELECT ar.*, a.owner
            FROM {artefact} a 
            JOIN {' . $othertable . '} ar ON ar.artefact = a.id
            WHERE a.owner = ? AND a.artefacttype = ?
            ORDER BY ar.displayorder';

        if (!empty($options['viewid'])) { 
            require_once('view.php');
            $v = new View($options['viewid']);
            $owner = $v->get('owner');
        }

        if (!$data = get_records_sql_array($sql, array($owner, $type))) {
            $data = array();
        }

        // Give the artefact type a chance to format the data how it sees fit
        $data = call_static_method(generate_artefact_class_name($type), 'format_render_self_data', $data);
        $smarty->assign('rows', $data);
        $this->render_license($options, $smarty);

        $content = array(
            'html'         => $smarty->fetch('artefact:results:fragments/' . $type . '.tpl'),
            'javascript'   => $this->get_showhide_composite_js()
        );
        return $content;
    }

    public static function get_js(array $compositetypes) {
        $js = self::get_common_js();
        foreach ($compositetypes as $compositetype) {
            $js .= call_static_method(
                generate_artefact_class_name($compositetype),
                'get_artefacttype_js',
                $compositetype
            );
        }
        return $js;
    }

    public static function get_common_js() {
        $cancelstr = json_encode(get_string('cancel'));
        $addstr = json_encode(get_string('add'));
        $confirmdelstr = get_string('compositedeleteconfirm', 'artefact.results');
        $js = <<<EOF
var tableRenderers = {};

function toggleCompositeForm(type) {
    var elemName = '';
    elemName = type + 'form';
    if (hasElementClass(elemName, 'hidden')) {
        removeElementClass(elemName, 'hidden');
        $('add' + type + 'button').innerHTML = {$cancelstr};
    }
    else {
        $('add' + type + 'button').innerHTML = {$addstr};
        addElementClass(elemName, 'hidden');
    }
}

function compositeSaveCallback(form, data) {
    key = form.id.substr(3);
    tableRenderers[key].doupdate(); 
    toggleCompositeForm(key);
    // Can't reset() the form here, because its values are what were just submitted, 
    // thanks to pieforms
    forEach(form.elements, function(element) {
        if (hasElementClass(element, 'text') || hasElementClass(element, 'textarea')) {
            element.value = '';
        }
    });
}

function deleteComposite(type, id, artefact) {
    if (confirm('{$confirmdelstr}')) {
        sendjsonrequest('compositedelete.json.php',
            {'id': id, 'artefact': artefact},
            'GET',
            function(data) {
                tableRenderers[type].doupdate();
            },
            function() {
                // @todo error
            }
        );
    }
    return false;
}

function moveComposite(type, id, artefact, direction) {
    sendjsonrequest('compositemove.json.php',
        {'id': id, 'artefact': artefact, 'direction':direction},
        'GET',
        function(data) {
            tableRenderers[type].doupdate();
        },
        function() {
            // @todo error
        }
    );
    return false;
}
EOF;
        $js .= self::get_showhide_composite_js();
        return $js;
    }

    static function get_tablerenderer_title_js($titlestring, $bodystring) {
        return "
                function (r, d) {
                    if (!{$bodystring}) {
                        return TD(null, {$titlestring});
                    }
                    var link = A({'href': ''}, {$titlestring});
                    connect(link, 'onclick', function (e) {
                        e.stop();
                        return showhideComposite(r, {$bodystring});
                    });
                    return TD({'id': 'composite-' + r.artefact + '-' + r.id}, link);
                },
                ";
    }

    static function get_showhide_composite_js() {
        return "
            function showhideComposite(r, content) {
                // get the reference for the title we just clicked on
                var titleTD = $('composite-' + r.artefact + '-' + r.id);
                var theRow = titleTD.parentNode;
                var bodyRow = $('composite-body-' + r.artefact +  '-' + r.id);
                if (bodyRow) {
                    if (hasElementClass(bodyRow, 'hidden')) {
                        removeElementClass(bodyRow, 'hidden');
                    }
                    else {
                        addElementClass(bodyRow, 'hidden');
                    }
                    return false;
                }
                // we have to actually create the dom node too
                var colspan = theRow.childNodes.length;
                var newRow = TR({'id': 'composite-body-' + r.artefact + '-' + r.id}, 
                    TD({'colspan': colspan}, content)); 
                insertSiblingNodesAfter(theRow, newRow);
            }
        ";
    }

    static function get_artefacttype_js($compositetype) {
        global $THEME;
        $editstr = get_string('edit');
        $delstr = get_string('delete');
        $imagemoveblockup   = json_encode($THEME->get_url('images/move-up.gif'));
        $imagemoveblockdown = json_encode($THEME->get_url('images/move-down.gif'));
        $upstr = get_string('moveup', 'artefact.results');
        $downstr = get_string('movedown', 'artefact.results');

        $js = call_static_method(generate_artefact_class_name($compositetype), 'get_composite_js');

        $js .= <<<EOF
tableRenderers.{$compositetype} = new TableRenderer(
    '{$compositetype}list',
    'composite.json.php',
    [
EOF;

        $js .= <<<EOF

        function (r, d) {
            var buttons = [];
            if (r._rownumber > 1) {
                var up = A({'href': ''}, IMG({'src': {$imagemoveblockup}, 'alt':'{$upstr}'}));
                connect(up, 'onclick', function (e) {
                    e.stop();
                    return moveComposite(d.type, r.id, r.artefact, 'up');
                });
                buttons.push(up);
            }
            if (!r._last) {
                var down = A({'href': '', 'class':'movedown'}, IMG({'src': {$imagemoveblockdown}, 'alt':'{$downstr}'}));
                connect(down, 'onclick', function (e) {
                    e.stop();
                    return moveComposite(d.type, r.id, r.artefact, 'down');
                });
                buttons.push(' ');
                buttons.push(down);
            }
            return TD({'class':'movebuttons'}, buttons);
        },
EOF;

        $js .= call_static_method(generate_artefact_class_name($compositetype), 'get_tablerenderer_js');

        $js .= <<<EOF
        function (r, d) {
            var editlink = A({'href': 'editcomposite.php?id=' + r.id + '&artefact=' + r.artefact, 'title': '{$editstr}'}, IMG({'src': config.theme['images/edit.gif'], 'alt':'{$editstr}'}));
            var dellink = A({'href': '', 'title': '{$delstr}'}, IMG({'src': config.theme['images/icon_close.gif'], 'alt': '[x]'}));
            connect(dellink, 'onclick', function (e) {
                e.stop();
                return deleteComposite(d.type, r.id, r.artefact);
            });
            return TD({'class':'right'}, null, editlink, ' ', dellink);
        }
    ]
);

tableRenderers.{$compositetype}.type = '{$compositetype}';
tableRenderers.{$compositetype}.statevars.push('type');
tableRenderers.{$compositetype}.emptycontent = '';
tableRenderers.{$compositetype}.updateOnLoad();

EOF;
        return $js;
    }

    static function get_composite_js() {
        return '';
    }

    static function get_forms(array $compositetypes) {
        require_once(get_config('libroot') . 'pieforms/pieform.php');
        $compositeforms = array();
        foreach ($compositetypes as $compositetype) {
            $elements = call_static_method(generate_artefact_class_name($compositetype), 'get_addform_elements');
            $elements['submit'] = array(
                'type' => 'submit',
                'value' => get_string('save'),
            );
            $elements['compositetype'] = array(
                'type' => 'hidden',
                'value' => $compositetype,
            );
            $cform = array(
                'name' => 'add' . $compositetype,
                'plugintype' => 'artefact',
                'pluginname' => 'results',
                'elements' => $elements,
                'jsform' => true,
                'successcallback' => 'compositeform_submit',
                'jssuccesscallback' => 'compositeSaveCallback',
            );
            $compositeforms[$compositetype] = pieform($cform);
        }
        return $compositeforms;
    }

}

class ArtefactType2ndsemesterresults extends ArtefactTypeResultsComposite { 

    protected $subjectcode;
    protected $credit;
    //protected $employer;

    public static function get_tablerenderer_js() {
        return "
                'subjectcode',
                'credit',
                " . ArtefactTypeResultsComposite::get_tablerenderer_title_js(
                    self::get_tablerenderer_title_js_string(),
                    self::get_tablerenderer_body_js_string()
                ) . "
        ";
    }

    public static function get_tablerenderer_title_js_string() {
        return " r.jobtitle + ': ' + r.employer";
    }

    public static function get_tablerenderer_body_js_string() {
        return " r.positiondescription";
    }

    public static function get_addform_elements() {
        return array(
            'subjectcode' => array(
                'type' => 'text',
                'rules' => array(
                    'required' => true,
                ),
                'title' => get_string('subjectcode', 'artefact.results'),
                'size' => 20,
                'help' => true,
            ),
            'credit' => array(
                'type' => 'text', 
                'title' => get_string('credit', 'artefact.results'),
                'size' => 20,
            ),
            /*'employer' => array(
                'type' => 'text',
                'rules' => array(
                    'required' => true,
                ),
                'title' => get_string('employer', 'artefact.resume'),
                'size' => 50,
            ),
            'employeraddress' => array(
                'type' => 'text',
                'title' => get_string('employeraddress', 'artefact.resume'),
                'size' => 50,
            ),
            'jobtitle' => array(
                'type' => 'text',
                'rules' => array(
                    'required' => true,
                ),
                'title' => get_string('jobtitle', 'artefact.resume'),
                'size' => 50,
            ),
            'positiondescription' => array(
                'type' => 'textarea',
                'rows' => 10,
                'cols' => 50,
                'resizable' => false,
                'title' =>  get_string('jobdescription', 'artefact.resume'),
            ),*/
        );
    }

    public static function bulk_delete($artefactids) {
        ArtefactTypeResultsComposite::bulk_delete_composite($artefactids, '2ndsemesterresults');
    }
}

class ArtefactTypeEduhistory extends ArtefactTypeResultsComposite {

    protected $startdate;
    protected $enddate;
    protected $qualtype;
    protected $institution;

    public static function get_tablerenderer_js() {

        return "
                'startdate',
                'enddate',
                " . ArtefactTypeResultsComposite::get_tablerenderer_title_js(
                    self::get_tablerenderer_title_js_string(),
                    self::get_tablerenderer_body_js_string()
                ) . "
        ";
    }

    public static function get_tablerenderer_title_js_string() {
        return " formatQualification(r.qualname, r.qualtype, r.institution)";
    }

    public static function format_render_self_data($data) {
        $at = get_string('at');
        foreach ($data as &$row) {
            $row->qualification = '';
            if (strlen($row->qualname) && strlen($row->qualtype)) {
                $row->qualification = $row->qualname. ' (' . $row->qualtype . ') ' . $at . ' ';
            }
            else if (strlen($row->qualtype)) {
                $row->qualification = $row->qualtype . ' ' . $at . ' ';
            }
            else if (strlen($row->qualname)) {
                $row->qualification = $row->qualname . ' ' . $at . ' ';
            }
            $row->qualification .= $row->institution;
        }
        return $data;
    }

    public static function get_tablerenderer_body_js_string() {
        return " r.qualdescription"; 
    }

    public static function get_addform_elements() {
        return array(
            'startdate' => array(
                'type' => 'text',
                'rules' => array(
                    'required' => true,
                ),
                'title' => get_string('startdate', 'artefact.resume'),
                'size' => 20,
                'help' => true,
            ),
            'enddate' => array(
                'type' => 'text', 
                'title' => get_string('enddate', 'artefact.resume'),
                'size' => 20,
            ),
            'institution' => array(
                'type' => 'text',
                'rules' => array(
                    'required' => true,
                ),
                'title' => get_string('institution', 'artefact.resume'),
                'size' => 50,
            ),
            'institutionaddress' => array(
                'type' => 'text',
                'title' => get_string('institutionaddress', 'artefact.resume'),
                'size' => 50,
            ),
			'alindexno' => array(
                'type' => 'text',
                'title' => get_string('alindexno', 'artefact.resume'),
                'size' => 50,
            ),
			'zscore' => array(
                'type' => 'text',
                'title' => get_string('zscore', 'artefact.resume'),
                'size' => 50,
            ),
            'qualtype' => array(
                'type' => 'text',
                'title' => get_string('qualtype', 'artefact.resume'),
                'size' => 50,
            ),
            'qualname' => array(
                'type' => 'text',
                'title' => get_string('qualname', 'artefact.resume'),
                'size' => 50,
            ),
            'qualdescription' => array(
                'type' => 'textarea',
                'rows' => 10,
                'cols' => 50,
                'resizable' => false,
                'title' => get_string('qualdescription', 'artefact.resume'),
            ),
        );
    }

    static function get_composite_js() {
        $at = get_string('at');
        return <<<EOF
function formatQualification(name, type, institution) {
    var qual = '';
    if (name && type) {
        qual = name + ' (' + type + ') {$at} ';
    }
    else if (type) {
        qual = type + ' {$at} ';
    }
    else if (name) {
        qual = name + ' {$at} ';
    }
    qual += institution;
    return qual;
}
EOF;
    }

    public static function bulk_delete($artefactids) {
        ArtefactTypeResultsComposite::bulk_delete_composite($artefactids, 'educationhistory');
    }
}

/*class ArtefactTypeCertification extends ArtefactTypeResultsComposite { 

    protected $date;

    public static function get_tablerenderer_js() {
        return "
                'date',
                " . ArtefactTypeResultsComposite::get_tablerenderer_title_js(
                    self::get_tablerenderer_title_js_string(),
                    self::get_tablerenderer_body_js_string()
                ) . "
        ";
    }

    public static function get_tablerenderer_title_js_string() {
        return "r.title";
    }

    public static function get_tablerenderer_body_js_string() {
        return "r.description";
    }

    public static function get_addform_elements() {
        return array(
            'date' => array(
                'type' => 'text',
                'rules' => array(
                    'required' => true,
                ),
                'title' => get_string('date', 'artefact.results'),
                'size' => 20,
                'help' => true,
            ),
            'title' => array(
                'type' => 'text',
                'rules' => array(
                    'required' => true,
                ),
                'title' => get_string('title', 'artefact.results'),
                'size' => 20,
            ),
            'description' => array(
                'type' => 'textarea',
                'rows' => 10,
                'cols' => 50,
                'resizable' => false,
                'title' => get_string('description'),
            ),
        );
    }

    public static function bulk_delete($artefactids) {
        ArtefactTypeResultsComposite::bulk_delete_composite($artefactids, 'certification');
    }
}*/

/*class ArtefactTypeBook extends ArtefactTypeResultsComposite {

    protected $date;
    protected $contribution;

    public static function get_tablerenderer_js() {
        return "
                'date',
                " . ArtefactTypeResultsComposite::get_tablerenderer_title_js(
                    self::get_tablerenderer_title_js_string(),
                    self::get_tablerenderer_body_js_string()
                ) . "
        ";
    }

    public static function get_tablerenderer_title_js_string() {
        return "r.title + ' (' + r.contribution + ')'";
    }

    public static function get_tablerenderer_body_js_string() {
        return "r.description";
    }

    public static function get_addform_elements() {
        return array(
            'date' => array(
                'type' => 'text',
                'rules' => array(
                    'required' => true,
                ),
                'title' => get_string('date', 'artefact.resume'),
                'help' => true,
                'size' => 20,
            ),
            'title' => array(
                'type' => 'text',
                'rules' => array(
                    'required' => true,
                ),
                'title' => get_string('title', 'artefact.resume'),
                'size' => 50,
            ),
            'contribution' => array(
                'type' => 'text',
                'rules' => array(
                    'required' => true,
                ),
                'title' => get_string('contribution', 'artefact.resume'),
                'size' => 50,
            ),
            'description' => array(
                'type' => 'textarea',
                'rows' => 10,
                'cols' => 50,
                'resizable' => false,
                'title' => get_string('detailsofyourcontribution', 'artefact.resume'),
            ),
        );
    }

    public static function bulk_delete($artefactids) {
        ArtefactTypeResultsComposite::bulk_delete_composite($artefactids, 'book');
    }
}*/

/*class ArtefactTypeMembership extends ArtefactTypeResultsComposite { 

    protected $startdate;
    protected $enddate;

    public static function get_tablerenderer_js() {
        return "
                'startdate',
                'enddate',
                " . ArtefactTypeResultsComposite::get_tablerenderer_title_js(
                    self::get_tablerenderer_title_js_string(),
                    self::get_tablerenderer_body_js_string()
                ) . "
        ";
    }

    public static function get_tablerenderer_title_js_string() {
        return "r.title";
    }
   
    public static function get_tablerenderer_body_js_string() {
        return "r.description";
    }

    public static function get_addform_elements() {
        return array(
            'startdate' => array(
                'type' => 'text',
                'rules' => array(
                    'required' => true,
                ),
                'title' => get_string('startdate', 'artefact.resume'),
                'help' => true,
                'size' => 20,
            ),
            'enddate' => array(
                'type' => 'text', 
                'title' => get_string('enddate', 'artefact.resume'),
                'size' => 20,
            ),
            'title' => array(
                'type' => 'text',
                'rules' => array(
                    'required' => true,
                ),
                'title' => get_string('title', 'artefact.resume'),
                'size' => 50,
            ),
            'description' => array(
                'type' => 'textarea',
                'rows' => 10,
                'cols' => 50,
                'resizable' => false,
                'title' => get_string('description', 'artefact.resume'),
            ),
        );
    }

    public static function bulk_delete($artefactids) {
        ArtefactTypeResultsComposite::bulk_delete_composite($artefactids, 'membership');
    }
}*/

/*class ArtefactTypeResultsGoalAndSkill extends ArtefactTypeResults {

    public static function is_singular() {
        return true;
    }
}*/

//class ArtefactTypePersonalgoal extends ArtefactTypeResultsGoalAndSkill { }
//class ArtefactTypeAcademicgoal extends ArtefactTypeResultsGoalAndSkill { }
//class ArtefactTypeCareergoal extends ArtefactTypeResultsGoalAndSkill { }
//class ArtefactTypePersonalskill extends ArtefactTypeResultsGoalAndSkill { }
//class ArtefactTypeAcademicskill extends ArtefactTypeResultsGoalAndSkill { }
//class ArtefactTypeWorkskill extends ArtefactTypeResultsGoalAndSkill { }

function compositeapp_submit(Pieform $form, $values) {
    try {
        call_static_method(generate_artefact_class_name($values['compositetype']), 
            'process_compositeform', $form, $values);
    }
    catch (Exception $e) {
        $form->json_reply(PIEFORM_ERR, $e->getMessage());
    }
    $form->json_reply(PIEFORM_OK, get_string('compositesaved', 'artefact.results'));
}

function compositeformed_submit(Pieform $form, $values) {
    global $SESSION;

    $tabs = PluginArtefactResults::composite_tabs();
    $goto = get_config('wwwroot') . '/artefact/results/';
    if (isset($tabs[$values['compositetype']])) {
        $goto .= $tabs[$values['compositetype']] . '.php';
    }
    else {
        $goto .='index.php';
    }

    try {
        call_static_method(generate_artefact_class_name($values['compositetype']),
            'process_compositeform', $form, $values);
    }
    catch (Exception $e) {
        $SESSION->add_error_msg(get_string('compositesavefailed', 'artefact.results'));
        redirect($goto);
    }
    $SESSION->add_ok_msg(get_string('compositesaved', 'artefact.results'));
    redirect($goto);
}

function simple_resumefield_app($defaults, $goto) {
    global $simple_resume_artefacts, $simple_resume_types;
    $simple_resume_artefacts = array();
    $simple_resume_types = array_keys($defaults);

    $form = array(
        'name'              => 'resumefieldform',
        'plugintype'        => 'artefact',
        'pluginname'        => 'results',
        'jsform'            => true,
        'successcallback'   => 'simple_resumefield_submit',
        'jssuccesscallback' => 'simple_resumefield_success',
        'jserrorcallback'   => 'simple_resumefield_error',
        'elements'          => array(),
    );

    foreach ($simple_resume_types as $t) {
        try {
            $simple_resume_artefacts[$t] = artefact_instance_from_type($t);
            $content = $simple_resume_artefacts[$t]->get('description');
        }
        catch (Exception $e) {
            $content = $defaults[$t]['default'];
        }
        $fieldset = $t . 'fs';
        $form['elements'][$fieldset] = array(
            'type' => 'fieldset',
            'legend' => get_string($t, 'artefact.results'),
            'elements' => array(
                $t => array(
                    'type' => 'wysiwyg',
                    'class' => 'js-hidden',
                    'rows' => 20,
                    'cols' => 65,
                    'defaultvalue' => $content,
                    'rules' => array('maxlength' => 65536),
                ),
                $t . 'submit' => array(
                    'type' => 'submitcancel',
                    'class' => 'js-hidden',
                    'value' => array(get_string('save'), get_string('cancel')),
                    'goto' => get_config('wwwroot') . $goto,
                ),
                $t . 'display' => array(
                    'type' => 'html',
                    'class' => 'nojs-hidden-block',
                    'value' => $content,
                ),
                $t . 'edit' => array(
                    'type' => 'button',
                    'class' => 'nojs-hidden-block openedit',
                    'value' => get_string('edit'),
                ),
            ),
        );
        if (!empty($defaults[$t]['fshelp'])) {
            $form['elements'][$fieldset]['help'] = true;
        }
    }

    $form['elements']['goto'] = array(
        'type'  => 'hidden',
        'value' => $goto,
    );

    return $form;
}

function simple_resumefiel_submit(Pieform $form, $values) {
    global $simple_resume_types, $simple_resume_artefacts, $USER;

    foreach ($simple_resume_types as $t) {
        if (isset($values[$t . 'submit']) && isset($values[$t])) {
            if (!isset($simple_resume_artefacts[$t])) {
                $classname = generate_artefact_class_name($t);
                $simple_resume_artefacts[$t] = new $classname(0, array(
                    'owner' => $USER->get('id'),
                    'title' => get_string($t),
                ));
            }
            $simple_resume_artefacts[$t]->set('description', $values[$t]);
            $simple_resume_artefacts[$t]->commit();
            $data = array(
                'message' => get_string('goalandskillsaved', 'artefact.results'),
                'update'  => $t,
                'content' => clean_html($values[$t]),
                'goto'    => get_config('wwwroot') . $values['goto'],
            );
            $form->reply(PIEFORM_OK, $data);
        }
    }

    $form->reply(PIEFORM_OK, array('goto' => get_config('wwwroot') . $values['goto']));
}

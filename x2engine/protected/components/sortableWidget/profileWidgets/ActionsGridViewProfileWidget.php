<?php
/***********************************************************************************
 * X2Engine Open Source Edition is a customer relationship management program developed by
 * X2 Engine, Inc. Copyright (C) 2011-2018 X2 Engine Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY X2ENGINE, X2ENGINE DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact X2Engine, Inc. P.O. Box 610121, Redwood City,
 * California 94061, USA. or at email address contact@x2engine.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * X2 Engine" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by X2 Engine".
 **********************************************************************************/

 Yii::import ('application.components.sortableWidget.ProfileGridViewWidget');

/**
 * @package application.components
 */
class ActionsGridViewProfileWidget extends ProfileGridViewWidget {

    public $canBeDeleted = true;

    public $defaultTitle = 'Actions Summary';

    public $relabelingEnabled = true;

    public $template = '<div class="submenu-title-bar widget-title-bar">{widgetLabel}{closeButton}{minimizeButton}{settingsMenu}</div>{widgetContents}';
    
    private static $_JSONPropertiesStructure;

    protected $_viewFileParams;

    /**
     * @var array the config array passed to widget ()
     */
    private $_gridViewConfig;

    protected function getModel () {
        if (!isset ($this->_model)) {
            $this->_model = new Actions ('search',
                $this->widgetKey,
                $this->getWidgetProperty ('dbPersistentGridSettings'));

            $this->afterGetModel ();
        }
        return $this->_model;
    }

    public static function getJSONPropertiesStructure () {
        if (!isset (self::$_JSONPropertiesStructure)) {
            self::$_JSONPropertiesStructure = array_merge (
                parent::getJSONPropertiesStructure (),
                array (
                    'label' => 'Actions Summary',
                    'hidden' => true
                )
            );
        }
        return self::$_JSONPropertiesStructure;
    }

    public function getDataProvider () {
        if (!isset ($this->_dataProvider)) {
            $resultsPerPage = self::getJSONProperty (
                $this->profile, 'resultsPerPage', $this->widgetType, $this->widgetUID);
            $this->_dataProvider = $this->model->searchIndex (
                $resultsPerPage, $this->widgetKey);
        }
        return $this->_dataProvider;
    }

    /**
     * @return array the config array passed to widget ()
     */
    public function getGridViewConfig () {
        if (!isset ($this->_gridViewConfig)) {
            $this->_gridViewConfig = array_merge (
                parent::getGridViewConfig (),
                array (
                    'massActions' => array (
                        'MassDelete', 'MassTag', 'MassUpdateFields', 
                        'MassCompleteAction', 'MassUncompleteAction',
                    ),
                    'enableQtips' => true,
                    'qtipManager' => array (
                        'X2GridViewQtipManager',
                        'loadingText'=> addslashes(Yii::t('app','loading...')),
                        'qtipSelector' => ".contact-name",
                    ),
                    'moduleName' => 'Actions',
                	'defaultGvSettings'=>array(
                		'gvCheckbox' => 30,
                		'actionDescription' => 140,
                		'associationName' => 165,
                		'assignedTo' => 105,
                		'completedBy' => 86,
                		'createDate' => 79,
                		'dueDate' => 77,
                		'lastUpdated' => 79,
                	),
                	'specialColumns'=>array(
                		'actionDescription'=>array(
                            'header'=>Yii::t('actions','{Action} Description', array(
                                '{Action}' => Modules::displayName(false, 'Actions')
                            )),
                			'name'=>'actionDescription',
                			'value'=>
                                'CHtml::link(
                                    ($data->type=="attachment") ? 
                                        Media::attachmentActionText($data) : 
                                        CHtml::encode(
                                            Formatter::trimText($data->actionDescription)),
                                    Yii::app()->controller->createUrl (
                                        "actions/actions/view", 
                                        array("id"=>$data->id)))',
                			'type'=>'raw',
                            'filter' => false,
                            'sortable' => false,
                		),
                		'associationName'=>array(
                			'name'=>'associationName',
                			'header'=>Yii::t('actions','Association Name'),
                			'value'=>
                                'strcasecmp($data->associationName,"None") == 0 ? 
                                    Yii::t("app","None") : 
                                    CHtml::link(
                                        $data->associationName,
                                        Yii::app()->controller->createUrl (
                                            "/".$data->associationType."/".
                                            $data->associationType."/view",
                                            array ("id" => $data->associationId)),
                                        array("class"=>($data->associationType=="contacts" ? 
                                            "contact-name" : null)))',
                			'type'=>'raw',
                		),
                	),
                    'enableTags'=>true,
                )
            );
        }
        return $this->_gridViewConfig;
    }

}
?>

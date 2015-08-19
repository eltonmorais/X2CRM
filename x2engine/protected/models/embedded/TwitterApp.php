<?php

/*****************************************************************************************
 * X2Engine Open Source Edition is a customer relationship management program developed by
 * X2Engine, Inc. Copyright (C) 2011-2015 X2Engine Inc.
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
 * You can contact X2Engine, Inc. P.O. Box 66752, Scotts Valley,
 * California 95067, USA. or at email address contact@x2engine.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * X2Engine" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by X2Engine".
 *****************************************************************************************/

Yii::import('application.models.embedded.*');

/**
 * Authentication data for using a Twitter app to enable Twitter integration.
 *
 * @package application.models.embedded
 */
class TwitterApp extends JSONEmbeddedModel {

    public $oauthAccessToken = '';
    public $oauthAccessTokenSecret = '';
    public $consumerKey = '';
    public $consumerSecret = '';

    public function attributeLabels(){
        return array(
            'oauthAccessToken' => Yii::t('app','Access Token'),
            'oauthAccessTokenSecret' => Yii::t('app','Access Token Secret'),
            'consumerKey' => Yii::t('app','Consumer Key (API Key)'),
            'consumerSecret' => Yii::t('app','Consumer Secret (API Secret)'),
        );
    }

    public function modelLabel() {
        return Yii::t('app','Twitter App');
    }

    public function renderInput ($attr) {
        echo CHtml::activeTextField($this, $attr, $this->htmlOptions($attr, array (
            'class' => 'twitter-credential-input',
        )));
    }

    public function renderInputs(){
        $this->attributes = array (
            'oauthAccessToken' => null,
            'oauthAccessTokenSecret' => null,
            'consumerKey' => null,
            'consumerSecret' => null,
        );
        echo CHtml::activeLabel($this, 'consumerKey');
        $this->renderInput ('consumerKey');
        echo CHtml::activeLabel($this, 'consumerSecret');
        $this->renderInput ('consumerSecret');
        echo CHtml::activeLabel($this, 'oauthAccessToken');
        $this->renderInput ('oauthAccessToken');
        echo CHtml::activeLabel($this, 'oauthAccessTokenSecret');
        $this->renderInput ('oauthAccessTokenSecret');
        echo CHtml::errorSummary($this);
        echo '<br>';
        echo '<br>';
        echo $this->getInstructions ();
    }

    public function rules(){
        return array(
            array('oauthAccessToken,oauthAccessTokenSecret,consumerKey,consumerSecret', 'required'),
        );
    }

    private function getInstructions () {
        return 
            '
            <label>'.Yii::t('app', 'Configuring Twitter Integration').'</label>
            <hr>
            <ol>
                <li>'.Yii::t('app', 'Visit {link} and create a new Twitter app.', array (
                    '{link}' => 
                        '<a href="https://apps.twitter.com/">https://apps.twitter.com</a>'
                )).'
                </li>
                <li>'.Yii::t ('app', 'From your app\'s management page, navigate to the "Keys and Access Tokens" tab.').'
                </li>
                <li>'.Yii::t('app', 'Click the button labelled "Create my access token".').'
                </li>
                <li>'.Yii::t('app', 'Copy your "Consumer Key", "Consumer Secret", "Access Token", and "Access Token Secret" into the above corresponding fields.').'
                </li>
                <li>'.Yii::t('app', 'Save your X2CRM Twitter Integration settings.').'</li>
            </ol>
            ';
    }

}

?>
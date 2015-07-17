<?php

namespace yadjet\MultiLevelSelecter;

use yii\widgets\InputWidget;

/**
 * 多级下拉
 */
class MultiLevelSelecter extends InputWidget {

    public $config = [];
    private $_defaultConfig = [
        'file' => '',
        'itemName' => 'items',
        'defaultValue' => '',
        'hasTip' => false,
        'tipText' => '&nbsp;',
        'disabledCount' => 0,
    ];

    public function init() {
        $this->config = array_merge($this->_defaultConfig, $this->config);
    }

    public function run() {
        parent::run();
        list($name, $id) = $this->resolveNameID();
        if (isset($this->htmlOptions['id'])) {
            $id = $this->htmlOptions['id'];
        } else {
            $this->htmlOptions['id'] = $id;
        }
        if (isset($this->htmlOptions['name'])) {
            $name = $this->htmlOptions['name'];
        } else {
            $this->htmlOptions['name'] = $name;
        }

        $tips = ($this->config['hasTip'] ? $this->config['tipText'] : '');
        $baseDir = dirname(__FILE__);
        $assets = Yii::app()->getAssetManager()->publish($baseDir . DIRECTORY_SEPARATOR . 'assets');
        $cs = Yii::app()->getClientScript();
        $cs->registerScriptFile($assets . '/multilevel-select.min.js');
        $file = $this->config['file'];
        Yii::import('ext.helpers.FileSystemHelper');
        $cs->registerScriptFile($file . '?' . FileSystemHelper::lastChange(Yii::getPathOfAlias('webroot') . $file));
        $js = <<<EOP
drawSelect(document.getElementById("{$id}_render"), "{$this->config['itemName']}", 3, "{$name}", "{$this->config['defaultValue']}", "{$tips}", "required", "{$this->config['tipText']}", {$this->config['disabledCount']});
EOP;
        $cs->registerScript(__CLASS__, $js);
    }

}

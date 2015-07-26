<?php

namespace yadjet\MultiLevelSelecter;

use yii\helpers\Html;
use yii\base\Widget;

/**
 * 多级下拉
 */
class MultiLevelSelecter extends Widget
{

    public $form;
    public $htmlOptions = [];
    public $config = [];
    private $_defaultConfig = [
        'file' => '',
        'itemName' => 'items',
        'defaultValue' => '',
        'hasTip' => false,
        'tipText' => '&nbsp;',
        'disabledCount' => 0,
    ];

    public function init()
    {
        parent::init();
        $this->config = array_merge($this->_defaultConfig, $this->config);
    }

    public function run()
    {
        $id = $this->options['id'];
        $view = $this->getView();
        MultiLevelSelecterAsset::register($view);
        $tips = $this->config['hasTip'] ? $this->config['tipText'] : '';
        $name = Html::getInputName($this->model, $this->attribute);
        $view->registerJsFile($this->config['file']);
        $js = <<<EOT
drawSelect(document.getElementById("{$id}_render"), "{$this->config['itemName']}", 3, "{$name}", "{$this->config['defaultValue']}", "{$tips}", "required", "{$this->config['tipText']}", {$this->config['disabledCount']});
EOT;
        $view->registerJs($js);
        if ($this->hasModel()) {
            return $this->form->field($this->model, $this->attribute)->hiddenInput($this->htmlOptions);
        } else {
            list($name, $id) = $this->resolveNameID();
            return Html::textField($name, $this->value, $this->htmlOptions);
        }
    }

}

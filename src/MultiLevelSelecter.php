<?php

namespace yadjet\MultiLevelSelecter;

use yii\helpers\Html;
use yii\widgets\InputWidget;

/**
 * 多级下拉
 * 
 * @author hiscaler <hiscaler@gmail.com>
 */
class MultiLevelSelecter extends InputWidget
{

    public $form;
    public $options = [];
    public $htmlOptions = [];
    public $jsOptions = [];
    private $_defaultJsOptions = [
        'file' => null,
        'varName' => 'items',
        'defaultValue' => '',
        'hasTip' => false,
        'tipText' => '&nbsp;',
        'disabledCount' => 0,
    ];

    public function init()
    {
        parent::init();
        $this->jsOptions = array_merge($this->_defaultJsOptions, $this->jsOptions);
        if (!$this->jsOptions['file']) {
            throw new \yii\base\InvalidConfigException('Please provide javascript file path.');
        }
    }

    public function run()
    {
        if (!isset($this->options['id'])) {
            $id = $this->getId();
        } else {
            $id = $this->options['id'];
        }
        $view = $this->getView();
        MultiLevelSelecterAsset::register($view);
        $tips = $this->jsOptions['hasTip'] ? $this->jsOptions['tipText'] : '';
        $name = Html::getInputName($this->model, $this->attribute);
        $view->registerJsFile($this->jsOptions['file']);
        $js = <<<EOT
drawSelect(document.getElementById("{$id}-render"), "{$this->jsOptions['varName']}", 3, "{$name}", "{$this->jsOptions['defaultValue']}", "{$tips}", "required", "{$this->jsOptions['tipText']}", {$this->jsOptions['disabledCount']});
EOT;
        $view->registerJs($js);
        if ($this->hasModel()) {
            return $this->form->field($this->model, $this->attribute, ['template' => '{label}{input}' . Html::tag('div', null, ['id' => "{$id}-render"]) . '{hint}{error}'])->hiddenInput($this->htmlOptions);
        } else {
            list($name, $id) = $this->resolveNameID();
            return Html::textField($name, $this->value, $this->htmlOptions);
        }
    }

}

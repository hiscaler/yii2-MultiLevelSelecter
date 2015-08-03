<?php

namespace yadjet\MultiLevelSelecter;

use yii\web\AssetBundle;

/**
 * Multi level selecter asset
 * 
 * @author hiscaler <hiscaler@gmail.com>
 */
class MultiLevelSelecterAsset extends AssetBundle
{

    public $sourcePath = '@vendor/yadjet/yii2-multi-level-selecter/src/assets';
    public $js = [
        'multilevel-select.min.js',
    ];

}

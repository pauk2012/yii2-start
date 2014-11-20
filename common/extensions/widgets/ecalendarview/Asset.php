<?php

namespace common\extensions\widgets\ecalendarview;

use yii\web\AssetBundle;

/**
 * Module asset bundle.
 */
class Asset extends AssetBundle {
    /**
     * @inheritdoc
     */
    public $sourcePath = '@common/extensions/widgets/ecalendarview/assets';

    /**
     * @inheritdoc
     */
    public $js = [
        'ecalendarview.js'
    ];
    public $css = [
        'styles.css'
    ];


    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset'
    ];
}

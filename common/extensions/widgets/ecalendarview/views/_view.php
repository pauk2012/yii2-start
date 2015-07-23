<?php
/**
 * _view.php
 *
 * @author Martin Ludvik <matolud@gmail.com>
 * @copyright Copyright &copy; 2014 by Martin Ludvik
 * @license http://opensource.org/licenses/MIT MIT license
 */
?>
<?php /*if ($data->source->href): */?><!--<a href="<?php /*echo $data->source->href*/?>">--><?php /*endif;*/?>
<?php echo \yii\helpers\Html::encode($data->date->format('j')); ?>
    <?php /*if ($data->source->href): */?><!--</a><?php /*endif;*/?>
--><?php /*echo  join(',' ,$data->data)*/?>


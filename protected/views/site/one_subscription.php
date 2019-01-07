<?php
//$cs = Yii::app()->getClientScript();
//$cs->registerScriptFile(Yii::app()->baseUrl . '/js/multizoom.js');
//$cs->registerScriptFile(Yii::app()->baseUrl . '/js/jquery-ui.js');
//$cs->registerCssFile(Yii::app()->baseUrl . '/css/gallery.css');
?>
<div class="inner_page">
    <div class="fix">
        <div class="one_subscription">
            <h2><?php echo $allData[0]['name']; ?></h2>
            <div class="fl">
                <div class="photographs">
                    <div class="targetarea">
                        <?php echo CHtml::image(UtilityHtml::getImageDisplay($allData[0]['image_url']), '', array('id' => 'multizoom2', 'alt' => 'zoomable')); ?>
                    </div>                  
                    <div class="clear"></div>
                </div>
                <?php echo $allData[0]['description']; ?>
            </div>
            <div class="fr">
                <h4>Pricing Options</h4>
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'subscription-form',
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                ));
                ?>
                <ul class="pricing_options">
                    <?php
                    $defaultChecked = ($allData[0]['duration'] == 3) ? 1 : $allData[0]['duration'];
                    $amSelectedSubVideos = array();
                    // FOR GET PREVIOUS SELECTED VALUES IF EXISTS //
                    if (count($amSelectedPackageSubData) > 0) {
                        $defaultChecked = $amSelectedPackageSubData['duration'];
                        $amSelectedSubVideos = explode(',', $amSelectedPackageSubData['selvideo']);
                    }
                    // FOR DISPLAY MONTHLY  VALUE //
                    if ($allData[0]['duration'] == 1 || $allData[0]['duration'] == 3) {
                        ?>
                        <li>
                            <input type="radio" name="price" value="1" <?php echo ($defaultChecked == 1) ? 'checked="checked"' : ''; ?> />
                            <label><?php echo Common::priceFormat($allData[0]['price']); ?> - Monthly payment for 24 months</label>
                        </li>                    
                        <?php
                    }
                    // FOR DISPLAY YEARLY VALUE //
                    if ($allData[0]['duration'] == 2 || $allData[0]['duration'] == 3) {
                        ?>
                        <li>
                            <input type="radio" name="price" value="2" <?php echo ($defaultChecked == 2) ? 'checked="checked"' : ''; ?>/>
                            <label><?php echo Common::priceFormat($allData[0]['price_one_time']); ?> - Pay up front package</label>                            
                        </li>
                    <?php } ?>
                </ul>
                <?php
                echo CHtml::hiddenField('id', Yii::app()->request->getParam('id'));
                $amUserInfo = Yii::app()->admin->getState('admin');
                $btnSubmitStatus = (Yii::app()->user->isGuest || $amUserInfo['user_type'] == Yii::app()->params['user_type']['studio']) ? true : false;
                ?>
                <div class = "block">
                    <?php echo CHtml::submitButton('Subscribe/Apply', array('id' => 'subscribe', 'disabled' => (!$btnSubmitStatus) ? 'disabled' : '')); ?>
                </div>
                <h4>Included Videos (Available - <span id="limit"><?php echo $allData[0]['base_video_limit'] - count($amSelectedSubVideos); ?></span> )</h4>
                <div id="accordion">                    
                    <?php foreach ($subDetails as $sub) { ?>
                        <h3><?php echo $sub['name']; ?></h3>
                        <div><div style="height:200px;overflow: auto;padding:0; width:300px;border-bottom: 3px solid #E95490 !important;">
                                <ul>
                                    <?php
                                    foreach ($sub['videos']as $videos) {
                                        $smPackageSubVideos = $sub['id'] . '_' . $videos['id'];
                                        $ssConditionalChecked = in_array($smPackageSubVideos, $amSelectedSubVideos) ? "checked=checked" : "";
                                        echo '<li><input id="selvideos_' . $sub['id'] . '_' . $videos['id'] . '" type="checkbox" name="selvideo[]" value="' . $sub['id'] . '_' . $videos['id'] . '" ' . $ssConditionalChecked . ' />&nbsp;' . $videos['title'] . '</li>';
                                    }
                                    ?>
                                </ul>
                            </div></div>    
                    <?php } ?>
                </div>

            </div>
            <?php $this->endWidget(); ?>    
            <div class="clear"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $("[id^='selvideos_']").click(function() {
            var numberOfChecked = $('input:checkbox:checked').length;
            var limit = <?php echo $allData[0]['base_video_limit']; ?>;
            if (limit < numberOfChecked) {
                return false;
            }
            else
                $('#limit').html(<?php echo $allData[0]['base_video_limit'] ?> - numberOfChecked);
        });
        $("#subscribe").click(function() {
            var numberOfChecked = $('input:checkbox:checked').length;
            if (!numberOfChecked) {
                alert('No Video Selected !!!');
                return false;
            }
            else {
                if (numberOfChecked == <?php echo $allData[0]['base_video_limit'] ?>)
                    return true;
                else {
                    alert('Please select all available videos.');
                    return false;
                }
            }

        });
    })
</script>

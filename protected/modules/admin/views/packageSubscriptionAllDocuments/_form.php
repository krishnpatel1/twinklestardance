<div class="middle">
    <div class="fix">
        <div class="basic_nav">
            <div class="basic_nav_center">
                <?php
                $form = $this->beginWidget('GxActiveForm', array(
                    'id' => 'package-subscription-documents-form',
                    'enableAjaxValidation' => false,
                    'htmlOptions' => array('enctype' => 'multipart/form-data'),
                ));
                //echo $form->errorSummary($model); 
                if($model->isNewRecord):
                ?>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'subscription_id'); ?></h6>
                    <?php echo $form->dropDownList($model, 'subscription_id', $amSubscriptions); ?>
                    <?php echo $form->error($model, 'subscription_id'); ?>
                </div><!-- row -->
                <?php endif;?>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'document_title'); ?></h6>
                    <?php echo $form->textField($model, 'document_title', array('maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'document_title'); ?>
                </div><!-- row -->
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'document_name'); ?></h6>
                    <?php echo $form->fileField($model, 'document_name'); ?> 
                    <?php echo $form->error($model, 'document_name'); ?>
                </div><!-- row -->
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'document_url'); ?></h6>
                    <?php echo $form->textField($model, 'document_url'); ?> 
                    <?php echo $form->error($model, 'document_url'); ?>
                </div><!-- row -->
                <div class="info2">
                    <?php
                    echo GxHtml::submitButton(Yii::t('app', 'Save')) . '&nbsp;';
                    echo GxHtml::button(Yii::t('app', 'Cancel'), array('onclick' => 'javascript:history.back();'));
                    ?>                   
                </div>
                <?php $this->endWidget(); ?>
                <div class="clear"></div>
                <?php if ($model->id > 0): ?>
                    <div class="subscriptions">
                        <!-- FOR ADD BASE SUBSCRIPTION / VIDEOS -->
                        <div class="sub_left">
                            <?php
                            echo CHtml::link(CHtml::image(Yii::app()->baseUrl . "/images/icon/add_small.png", '', array('class' => 'icon')) . "Add Subscription", 'javascript:void(0);', array('onclick' => 'js:openColorBox("' . CController::createUrl("packageSubscriptionAllDocuments/addSubscription", array('id' => $model->id)) . '");return false;', 'class' => 'ajax buttons add_butt'));
                            $ssPostData = "document_id=" . $model->id;
                            if ($omModelTrans):
                                foreach ($omModelTrans as $omData):
                                    $ssName = $omData->subscription->name;
                                    $ssUpdateDivId = "base_sub_" . $omData->subscription->id;
                                    $ssLoaderDivId = "loader_base_sub_" . $omData->subscription->id;
                                    echo '<span id="' . $ssUpdateDivId . '" class="buttons">';
                                    echo $ssName;
                                    echo CHtml::link(CHtml::image(Yii::app()->baseUrl . "/images/icon/close_butt.png"), "javascript:void(0);", array("onclick" => "if(confirm('Are you sure?')){ajaxRequest('" . CController::createUrl('PackageSubscriptionAllDocuments/removeSubscriptionFromDocument', array('id' => $omData->subscription->id)) . "','" . $ssPostData . "','" . $ssUpdateDivId . "','" . $ssLoaderDivId . "')}else{return false;}", "class" => "close"));
                                    echo '<span id="' . $ssLoaderDivId . '" style="display:none">' . CHtml::image(Yii::app()->baseUrl . "/images/ajax_loading.gif") . '</span>';
                                    echo '</span>';

                                endforeach;
                            endif;
                            ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
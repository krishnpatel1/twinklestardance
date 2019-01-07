<div class="middle">
    <div class="fix">
        <div class="orders_page">
            <?php
            $form = $this->beginWidget('GxActiveForm', array(
                'id' => 'orders-form',
                'enableAjaxValidation' => false,
            ));
            ?>
            <div class="block">
                <?php echo GxHtml::button(Yii::t('app', 'Back'), array('onclick' => 'javascript:history.back();')); ?>
                <?php
                // CHECK IF PAYMENT TYPE IS MONTHLY RECURRING //
                if ($model->payment_type == 1 && $model->recurring_profile_id != NULL):
                    echo GxHtml::button(Yii::t('app', 'Payment History'), array('onclick' => 'js:scrollColorBox("' . CController::createUrl("orders/paymentHistory", array('id' => $model->recurring_profile_id)) . '");return false;', 'class' => 'ajax'));
                endif;
                ?>
                <div class="clear"></div>
            </div>
            <div class="tabel">
                <table border="0" width="100%" style="font-size: 18px;vertical-align: middle;">
                    <tr>
                        <td align="left">Name</td>
                        <td>:<?php echo ucfirst($model->user->first_name . ' ' . $model->user->last_name); ?></td>
                        <td align="left">Payment Date</td>
                        <td>:<?php echo date("m/d/Y", strtotime($model->payment_date)); ?></td>
                    </tr>
                    <tr>
                        <td align="left">Email</td>
                        <td>:<?php echo $model->user->email; ?></td>
                        <td align="left">Order No.</td>
                        <td>:<?php echo $model->id; ?></td>
                    </tr>
                    <tr>
                        <td align="left">Studio Name</td>
                        <td>:<?php echo ucfirst($model->user->studio_name); ?></td>
                        <td align="left">Street Address</td>
                        <td>:<?php echo ($model->user->address_1 != '') ? ucfirst($model->user->address_1) : '-'; ?></td>
                    </tr>                    
                    <tr>
                        <td align="left">City</td>
                        <td>:<?php echo ($model->user->city != '') ? ucfirst($model->user->city) : '-'; ?></td>
                        <td align="left">State/Province</td>
                        <td>:<?php echo ($model->user->state) ? ucfirst($model->user->state->state_name) : "-"; ?></td>
                    </tr>                    
                    <tr>
                        <td align="left">Zip/Postal Code</td>
                        <td>:<?php echo ($model->user->zip != '') ? $model->user->zip : '-'; ?></td>
                    </tr>
                    <tr>
                        <td align="left">Phone</td>
                        <td>:<?php echo ($model->user->phone != '') ? $model->user->phone : '-'; ?></td>
                    </tr>
                </table>
                <div class="sub_tab table_list_order">
                    <div class="title">
                        <div class="subscription">
                            <?php echo $ssPackageSubVideoName = ($omOrderDetails) ? Yii::t('app', 'Package/Subscription') : Yii::t('app', 'Videos'); ?>
                        </div>
                        <div class="price"><?php echo Yii::t('app', 'Price'); ?></div>
                        <div class="day"><?php echo Yii::t('app', 'Term'); ?></div>
                        <div class="expired"><font><?php echo Yii::t('app', 'Expiration Date'); ?></font></div>
                        <div class="status"><font><?php echo Yii::t('app', 'Status'); ?></font></div>
                    </div>

                    <!-- START FOR DISPLAY LIST OF PACKAGES/SUBSCRIPTION(STUDIOS), VIDEOS (DANCERS) INCLUDED INTO THIS ORDER -->                   
                    <?php
                    if ($omOrderDetails):
                        $snI = 0;
                        foreach ($omOrderDetails as $omDataSet):
                            foreach ($omDataSet->orderDetails as $omDetailsData):
                                ?>
                                <div class="row">
                                    <div class="subscription">
                                        <?php echo $omDetailsData->packageSubscription->name; ?>
                                    </div>
                                    <div class="price">
                                        <?php echo Common::priceFormat($omDetailsData->amount); ?>
                                    </div>
                                    <div class="day">
                                        <?php echo ($omDetailsData->duration == 1) ? "Monthly" : "Yearly"; ?>
                                    </div>
                                    <div class="expired">
                                        <?php $ssStyle = (strtotime($omDetailsData->expiry_date) < strtotime(date('Y-m-d H:i:s'))) ? 'style="cursor:pointer;color:red;font-weight:bold;"' : 'style="cursor:pointer;"' ?>
                                        <div id="label_field_<?php echo $omDetailsData->packageSubscription->id; ?>" onclick="showHideExpiryDate(<?php echo $omDetailsData->packageSubscription->id; ?>);" title="Click here to change date" <?php echo $ssStyle; ?>><?php echo date('m/d/Y', strtotime($omDetailsData->expiry_date)); ?></div>
                                        <div id="text_field_<?php echo $omDetailsData->packageSubscription->id; ?>" style="display:none;">
                                            <?php
                                            $form->widget('zii.widgets.jui.CJuiDatePicker', array(
                                                'id' => 'expiry_date_' . $omDetailsData->packageSubscription->id,
                                                'name' => 'expiry_date[' . $omDetailsData->order_id . '_' . $omDetailsData->packageSubscription->id . ']',
                                                //'mode' => 'datetime', //use "time","date" or "datetime" (default)
                                                'options' => array(
                                                    'showAnim' => 'fold',
                                                    'showTimepicker' => false,
                                                    'dateFormat' => 'mm/dd/yy',
                                                    //'timeFormat' => 'hh:mm',
                                                    'changeMonth' => true,
                                                    'changeYear' => true,
                                                    'minDate' => 'new Date()',
                                                    'yearRange' => date('Y') . ':2030',
                                                    'showButtonPanel' => true,
                                                ), // jquery plugin options
                                                'htmlOptions' => array(
                                                    'class' => 'price'
                                                ),
                                            ));
                                            ?>
                                        </div>
                                    </div>
                                    <?php if ($snI == 0): ?>
                                        <div class="status">
                                            <span class="dea_select">
                                                <?php echo $form->dropDownlist($model, 'payment_status', $model->getPaymentStatusOptions()); ?>
                                            </span>
                                        </div>
                                    <?php endif; ?>

                                </div>                    
                                <?php
                                $snI++;
                            endforeach;
                            break;
                        endforeach;
                    else:
                        if (count($omDancerOrderDetails) > 0):
                            $snI = 0;
                            foreach ($omDancerOrderDetails as $omDataSet):
                                ?>
                                <div class="row">
                                    <div class="subscription">
                                        <?php echo $omDataSet->title; ?>
                                    </div>
                                    <div class="price">
                                        <?php echo Common::priceFormat($omDataSet->price); ?>
                                    </div>
                                    <div class="day">
                                        <?php echo 'Not Applicable'; ?>
                                    </div>
                                    <div class="expired">
                                        <?php echo 'Not Applicable'; ?>
                                    </div>
                                    <?php if ($snI == 0): ?>
                                        <div class="status">
                                            <span class="dea_select">
                                                <?php echo $form->dropDownlist($model, 'payment_status', $model->getPaymentStatusOptions()); ?>
                                            </span>
                                        </div>
                                    <?php endif; ?>

                                </div>
                                <?php
                                $snI++;
                            endforeach;
                        endif;
                    endif;
                    ?>
                    <!--END FOR DISPLAY LIST OF PACKAGES/SUBSCRIPTION/VIDEOS INCLUDED INTO THIS ORDER-->
                </div>
                <div class = "sub_tab sub_tab2">
                    <div class = "title">
                        <div class = "subscription"><?php echo Yii::t('app', 'Subtotal');
                    ?></div>
                        <div class="price"><?php echo Common::priceFormat($model->sub_total); ?></div>
                    </div>
                    <div class="row">
                        <div class="subscription"><?php echo Yii::t('app', 'Tax'); ?></div>
                        <div class="price"><?php echo Common::priceFormat($model->tax); ?></div>
                    </div>
                    <div class="row">
                        <div class="subscription"><?php echo Yii::t('app', 'Total'); ?></div>
                        <div class="price"><strong><?php echo Common::priceFormat($model->amount_paid); ?></div></strong>
                    </div>
                    <div class="row">
                        <div class="subscription"><?php echo Yii::t('app', 'Notes'); ?></div>
                        <div class="price">
                            <?php echo $form->textArea($model, 'notes'); ?>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="sub_tab">
                    <div class="title">
                        <?php
                        $ssPostData = "order_id=" . $model->id;
                        echo GxHtml::button(Yii::t('app', 'Email'), array('id' => 'btn-email', 'onclick' => 'sendMailForOrderInfo("' . CController::createUrl('orders/emailOrderInfo') . '","' . $ssPostData . '","loader");return false;')) . '&nbsp;';
                        echo '<span id="loader" style="display:none">' . CHtml::image(Yii::app()->baseUrl . "/images/ajax_loading.gif") . '</span>';
                        echo GxHtml::submitButton(Yii::t('app', 'Apply'), array('id' => 'save-form'));
                        $this->endWidget();
                        ?>
                    </div>
                </div>
            </div>            
        </div>
    </div>
</div>
<script type="text/javascript">
                                            function showHideExpiryDate(snID) {
                                                $('#label_field_' + snID).hide();
                                                $('#text_field_' + snID).show();
                                            }
</script>

<div class="middle" style="width:1234px; margin:16px auto 0px; min-height:350px;">
    <div class="fix" style="width:660px; margin:0 auto;">
        <div class="orders_page" style="margin-top:9px;">            
            <div class="tabel" style="margin-top:28px; float:left;">
                <div class="mtitle" style="line-height:14px; font-size:18px; color:#555; float:left; width:100%;">
                    <div class="name" style="float:left; width:180px;"><?php echo ucfirst($model->user->first_name . ' ' . $model->user->last_name); ?></div>
                    <div class="date" style="text-align:center; width:145px; float:left;"><?php echo date("d/m/Y", strtotime($model->payment_date)); ?></div>
                    <div class="email" style="text-align:center; width:240px; float:left;"><?php echo $model->user->email; ?></div>
                    <div class="pack" style="text-align:right; float:right;"><?php echo $model->id; ?></div>
                </div>
                <div class="sub_tab" style="margin-top:60px; float:left;">
                    <div class="title" style="line-height:10px; font-weight:bold; color:#999; float:left; width:100%;">
                        <div class="subscription" style="float:left; width:174px;">
                            <?php //echo $ssPackageSubVideoName = ($model->packageSubscription) ? ($model->packageSubscription->type) : Yii::t('app', 'Videos'); ?>
                            <?php echo $ssPackageSubVideoName = ($omOrderDetails) ? Yii::t('app', 'Package/Subscription') : Yii::t('app', 'Videos'); ?>
                        </div>
                        <div class="price" style="float:left; width:130px;"><?php echo Yii::t('app', 'Price'); ?></div>
                        <div class="day" style="float:left; width:145px;"><?php echo Yii::t('app', 'Term'); ?></div>
                        <div class="status" style="float:left; width:210px;"><font style="margin-left:8px;"><?php echo Yii::t('app', 'Status'); ?></font></div>
                    </div>

                    <!-- START FOR DISPLAY LIST OF PACKAGES/SUBSCRIPTION(STUDIOS), VIDEOS (DANCERS) INCLUDED INTO THIS ORDER -->                   
                    <?php
                    if ($omOrderDetails):
                        $snI = 0;
                        foreach ($omOrderDetails as $omDataSet):
                            foreach ($omDataSet->orderDetails as $omDetailsData):
                                ?>                 
                                <div class="row" style="margin-top:25px; line-height:21px; color:#555; float:left; width:100%;">
                                    <div class="subscription" style="float:left; width:174px;">
                                        <?php echo $omDetailsData->packageSubscription->name; ?>
                                    </div>
                                    <div class="price" style="float:left; width:130px;">
                                        <?php echo Common::priceFormat($omDetailsData->amount); ?>
                                    </div>
                                    <div class="day" style="float:left; width:145px;">
                                       <?php echo ($omDetailsData->duration) ? "Monthly" : "Yearly"; ?>
                                    </div>                                    
                                    <?php if ($snI == 0): ?>
                                        <div class="status" style="float:left; width:210px;">
                                            <span class="dea_select">
                                                <?php echo $model->getPaymentStatusText(); ?>
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <?php $snI++;
                            endforeach;
                            break;
                        endforeach;
                    else:
                        if (count($omDancerOrderDetails) > 0):
                            $snI = 0;
                            foreach ($omDancerOrderDetails as $omDataSet):
                                ?>                    
                                <div class="row" style="margin-top:25px; line-height:21px; color:#555; float:left; width:100%;">
                                    <div class="subscription" style="float:left; width:174px;">
                                        <?php echo $omDataSet->title; ?>
                                    </div>
                                    <div class="price" style="float:left; width:130px;">
                                        <?php echo Common::priceFormat($omDataSet->price); ?>
                                    </div>
                                    <div class="day" style="float:left; width:145px;">
                                        <?php echo 'Not Applicable'; ?>
                                    </div>
                                    <div class="status" style="float:left; width:210px;">
                                        <span class="dea_select">
                                            <?php echo $model->getPaymentStatusText(); ?>
                                        </span>
                                    </div>                                    
                                </div>
                                <?php
                                $snI++;
                            endforeach;
                        endif;
                    endif;
                    ?>
                    <!--END FOR DISPLAY LIST OF PACKAGES/SUBSCRIPTION/VIDEOS INCLUDED INTO THIS ORDER-->
                </div>
                <div class = "sub_tab sub_tab2" style="width:100%; margin-top:60px; float:left; line-height:19px;">
                    <div class = "title" style="line-height:19px;float: left;">
                        <div class = "subscription" style="width:140px; font-weight:bold; color:#999; border:"><?php echo Yii::t('app', 'Subtotal');
                    ?></div>
                        <div class="price" style="width:78px; text-align:right; color:#555; font-weight:normal;"><?php echo Common::priceFormat($model->sub_total); ?></div>
                    </div>
                    <div class="row" style="margin-top:4px;clear: left;">
                        <div class="subscription" style="width:140px; font-weight:bold; color:#999;"><?php echo Yii::t('app', 'Tax'); ?></div>
                        <div class="price" style="width:78px; text-align:right; color:#555; font-weight:normal;"><?php echo Common::priceFormat($model->tax); ?></div>
                    </div>
                    <div class="row" style="margin-top:4px;clear: left;">
                        <div class="subscription" style="width:140px; font-weight:bold; color:#999;"><?php echo Yii::t('app', 'Total'); ?></div>
                        <div class="price" style="width:78px; text-align:right; color:#555; font-weight:normal;"><strong><?php echo Common::priceFormat($model->amount_paid); ?></div></strong>
                    </div>
                </div>
                <div class="clear" style="clear:both;"></div>                
            </div>            
        </div>
    </div>
</div>

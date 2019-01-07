<div class="inner_page">
    <div class="fix">
        <h2>My Cart</h2>
        <div class="flash_message">
            <?php
            foreach (Yii::app()->user->getFlashes() as $key => $message) {
                echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
            }
            ?>
        </div>
    </div>
    <div class="fix">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'cart-form',
            'enableClientValidation' => false,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            )
        ));
        ?>
        <div class="shopping_cart_page">
            <div class="title">
                <div class="checkbox">&nbsp;</div>
                <div class="item">Item</div>
                <div class="description">Description</div>
                <div class="" style="width:12%;float:left;text-align: center;">Duration</div>
                <div class="" style="width:8%;float:left;text-align: center;">Is Approved</div>
                <div class="subtotal">Subtotal</div>
            </div> 
            <?php
            $grandtot = $tot = 0;
            $bIsAllowYearlyCheckout = false;
            $abIsAllowMonthlyCheckout = array();
            if (count($cartItems) <= 0):
                ?>
                <div class="clear"></div>
                <div class="list">                                                    
                    <div class="flash-notice">Your cart is empty!</div>
                </div> 
            <?php else: ?>
                <div class="products_list">
                    <?php
                    //p($cartItems);
                    foreach ($cartItems as $item):
                        $tot = ($item['cart_duration'] == 1) ? $item['price'] : $item['price_one_time'];
                        $grandtot += $tot;
                        $abIsAllowMonthlyCheckout[] = ($item['cart_duration'] == 1 && $item['is_admin_approved'] == 1) ? true : false;
                        if ($item['cart_duration'] == 2)
                            $bIsAllowYearlyCheckout = true;
                        ?>
                        <div class="list">                    
                            <div class="checkbox"><?php echo CHtml::checkBox('itemids[]', '', array('value' => $item['id'])); ?></div>
                            <div class="item"><?php echo $item['name']; ?></div>
                            <div class="description"><?php echo implode(' ', array_slice(explode(' ', $item['description']), 0, 20)); //echo substr($item['description'],1,300);   ?>...</div>
                            <div style="width:12%;float:left;text-align: center;"><?php echo ($item['cart_duration'] == 1) ? 'Monthly' : 'Yearly'; ?></div>
                            <div style="width:8%;float:left;text-align: center;"><?php echo Yii::app()->params['defaultStatus'][$item['is_admin_approved']]; ?></div>
                            <div class="subtotal"><?php echo Common::priceFormat($tot); ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <div class="total">
                <?php echo GxHtml::submitButton(Yii::t('app', 'Delete'), array('class' => 'submit2', 'id' => 'delete-cart')); ?>
                <div class="fr">
                    <span class="price"><?php echo Common::priceFormat($grandtot); ?></span>
                    <span class="tot">Total</span>
                </div>
            </div>
            <div class="butt_nav">
                <?php
                echo GxHtml::button(Yii::t('app', 'Continue Shopping'), array('onclick' => 'window.location = "' . CController::createUrl('site/subscriptions') . '"')) . '&nbsp;';
                if (in_array(true, $abIsAllowMonthlyCheckout) || $bIsAllowYearlyCheckout):
                    if (count($cartItems) > 0)
                        echo GxHtml::submitButton(Yii::t('app', 'Checkout'), array('id' => 'checkout'));
                    else
                        echo GxHtml::button(Yii::t('app', 'Checkout'), array('onclick' => 'return false;'));
                else:
                    echo GxHtml::button(Yii::t('app', 'Waiting for Approval'), array('onclick' => 'return false;'));
                endif;
                ?> 
            </div>
            <div class="clear"></div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>

<script type="text/javascript">
    $("#delete-cart").click(function() {
        if ($('input:checkbox:checked').length > 0) {
            return confirm("Are you sure you want to delete?");
        } else {
            alert("Please select at least one item to perform this action.");
            return false;
        }
    });
</script>
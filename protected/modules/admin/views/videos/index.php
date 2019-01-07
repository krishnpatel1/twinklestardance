<?php
$this->breadcrumbs = array(
    Videos::label(2) => array('class' => 'display two active', 'label' => "<font>&nbsp;</font>" . Videos::label(2) . "<span>&nbsp;</span>")
);

if (AdminModule::isAdmin()) {
    $this->menu = array(
        array('label' => Yii::t('app', 'Switch to list view'), 'url' => array('admin')),
    );
}

if ($omOrderInfo):
    ?>
    <script type="text/javascript">
        _gaq.push(['_set', 'currencyCode', 'USD']);
    <?php if ($omOrderInfo->orderDetails): ?>
            _gaq.push(['_addTrans',
                '<?php echo $omOrderInfo->id; ?>', // transaction ID - required
                'TSD Subscriptions', // affiliation or store name
                '<?php echo $omOrderInfo->amount_paid; ?>', // total - required
                '0', // tax
                '0', // shipping
                '<?php echo $omOrderInfo->user->city; ?>', // city
                '<?php echo ($omOrderInfo->user->state) ? $omOrderInfo->user->state->state_name : ""; ?>', // state or province
                '<?php echo ($omOrderInfo->user->country) ? $omOrderInfo->user->country->country_code_iso3 : ""; ?>'             // country
            ]);

        <?php foreach ($omOrderInfo->orderDetails as $omOrderDetails):
            ?>
                // add item might be called for every item in the shopping cart
                // where your ecommerce engine loops through each item in the cart and
                // prints out _addItem for each
                _gaq.push(['_addItem',
                    '<?php echo $omOrderDetails->order_id; ?>', // transaction ID - required
                    '<?php echo base64_encode($omOrderDetails->package_subscription_id); ?>', // SKU/code - required
                    '<?php echo $omOrderDetails->packageSubscription->name; ?>', // product name
                    'Dance', // category or variation
                    '<?php echo $omOrderDetails->amount; ?>', // unit price - required
                    '1'               // quantity - required
                ]);
            <?php
        endforeach;
    endif;
    ?>
        _gaq.push(['_trackTrans']); //submits transaction to the Analytics servers 
    </script>
<?php endif; ?>
<div class="middle">
    <div class="fix videos">
        <?php
        if (AdminModule::isAdmin()) {
            $ssLinkName = "<span>" . CHtml::image(Yii::app()->request->baseUrl . "/images/icon/add.png") . "</span><font>Add Video</font>";
            echo CHtml::link($ssLinkName, Yii::app()->createUrl("admin/videos/create"), array("class" => "block add"));
        } elseif (AdminModule::isStudioAdmin()) {
            $ssLinkName = "<span>" . CHtml::image(Yii::app()->request->baseUrl . "/images/icon/updates_available.png") . "</span><font>Updates Available</font><div class='numb'>" . $snTotalAvailableVideo . "</div>";
            echo CHtml::link($ssLinkName, "javascript:void(0);", array("class" => "block add"));
        }

        $ssView = (AdminModule::isAdmin()) ? "_view" : "_view_other";
        $this->widget('zii.widgets.CListView', array(
            'dataProvider' => $dataProvider,
            'itemView' => $ssView,
            'template' => '{items}{pager}',
            'afterAjaxUpdate' => 'js:bindColorbox'
        ));
        ?>
        <div class="clear"></div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $(".ajax").colorbox();
    });
    function bindColorbox() {
        $(".ajax").colorbox();
    }
    function fb_share(ssTitle,ssImage,ssUrl) {

        FB.ui({
            method: 'feed',
            name: ssTitle,
            link: ssUrl,
            picture: ssImage,
            caption: 'Twinkle Star Dance',
            description: 'Twinkle Star Dance sample video description.'
        },
        function(response) {
            if (response && response.post_id) {
                alert('Your post has been successfully published.');
                self.close();
            } else {
                alert('Your post has not been published!');
                self.close();
            }
        });
    }
</script>
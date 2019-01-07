<?php
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
                '<?php echo $omOrderInfo->user->country->country_code_iso3; ?>'             // country
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
<div class="topmargin"></div>
<div class="middle">    
    <div class="fix videos"> 
        <div class="flash-success">Thank you for your order. Please contact to administrator to active your videos due to payment made through CASH / CHECK.</div>
    </div>
</div>
<div class="clear"></div>
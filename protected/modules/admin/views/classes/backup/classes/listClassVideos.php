<?php
$this->breadcrumbs = array(
    "<font>&nbsp;</font>" . Classes::label(2) . "<span>&nbsp;</span>" => array('class' => 'two', 'url' => array('index')),
    $oModelClass->name => array('class' => 'display two active', 'label' => "<font>&nbsp;</font>" . $oModelClass->name . " - " . Videos::label(2) . "<span>&nbsp;</span>")
);

$this->menu = array(
    array('label' => Yii::t('app', 'Switch to list view'), 'url' => array('/user/classes/videost/'.$classId)),        
);

if ($omOrderInfo):
    ?>
    <script type="text/javascript">
        _gaq.push(['_set', 'currencyCode', 'USD']);
        <?php if ($omOrderInfo->userVideosTransactions):?>
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

        <?php foreach ($omOrderInfo->userVideosTransactions as $omOrderDetails):

            ?>
        // add item might be called for every item in the shopping cart
        // where your ecommerce engine loops through each item in the cart and
        // prints out _addItem for each
        _gaq.push(['_addItem',
            '<?php echo $omOrderDetails->order_id; ?>', // transaction ID - required
            '<?php echo $omOrderDetails->video_id; ?>', // SKU/code - required
            '<?php echo $omOrderDetails->video->title; ?>', // product name
            'Dance', // category or variation
            '<?php echo $omOrderDetails->video->price; ?>', // unit price - required
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
        if (AdminModule::isDancer()):
            $this->beginWidget('GxActiveForm', array(
                'id' => 'purchase-video-form',
                'enableAjaxValidation' => false
            ));
            echo GxHtml::hiddenField("class_id", $oModelClass->id);
            echo GxHtml::submitButton(Yii::t('app', 'Buy Videos'), array('id' => 'buy-video', 'class' => 'submitbtnclass'));
        endif;
        echo '<div class="clear"></div>';
        $this->widget('zii.widgets.CListView', array(
            'dataProvider' => $dataProvider,
            'itemView' => '_view_class_videos',
            'template' => '{items}{pager}',
            'afterAjaxUpdate' => 'js:bindColorbox'
        ));
        if (AdminModule::isDancer()):
            $this->endWidget();
        endif;
        ?>
        <div class="clear"></div>
    </div>
</div>
<script type="text/javascript">
    $("#buy-video").click(function(){
        if ($('input:checkbox:checked').length > 0) {
            if(confirm("Parental supervision is required to make purchase.")){
                return true;
            }else{return false;}
        }else{
            alert("Please select at least one video to purchase.");
            return false;
        }
    });
    $(".videolink").click(function(){
        if (!$("#divselectvideo"+this.id).hasClass("add_block")) {
            $("#divselectvideo"+this.id).addClass("add_block");
            $("#videoid"+this.id).attr('checked','checked');
        }
        else{
            $("#divselectvideo"+this.id).removeClass("add_block");
            $("#videoid"+this.id).attr('checked', false);
        }
    });

    $(document).ready(function(){
        $(".ajax").colorbox();
    });
    function bindColorbox(){
        $(".ajax").colorbox();
    }

</script>
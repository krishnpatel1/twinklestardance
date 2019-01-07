<?php
$this->breadcrumbs = array(
    "<font>&nbsp;</font>" . Classes::label(2) . "<span>&nbsp;</span>" => array('class' => 'two', 'url' => array('index')),
    $oModelClass->name => array('class' => 'display two active', 'label' => "<font>&nbsp;</font>" . $oModelClass->name . " - " . Videos::label(2) . "<span>&nbsp;</span>")
);

$this->menu = array(
    array('label' => Yii::t('app', 'Switch to tile view'), 'url' => array('/user/classes/videos/'.$classId)),        
);


$vid_arr=Yii::app()->getRequest()->getParam('Videos');
//$ssLinkParams = (Yii::app()->getRequest()->getParam('package_id')) ? array('id' => $snPackageSubID, 'type' => $ssType, 'package_id' => Yii::app()->getRequest()->getParam('package_id')) : array('id' => $snPackageSubID, 'type' => $ssType);
//$ssLinkUrl = ($snTotalAvailableVideo > 0 && $ssType != "Package") ? Yii::app()->createUrl("admin/videos/chooseVideoToAddYourSubscription", $ssLinkParams) : "javascript:void(0);";

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
        
        <h1>Search videos</h1>
<?php
        $model = new Videos('search');
$form=$this->beginWidget('CActiveForm', array(
    'action'=>'/user/classes/videost/'.$classId,//.$ssLinkParams["id"].'/'.$ssLinkParams["type"]
    'method'=>'get',
)); ?>

    <div class="row row-spaced">
        <?php echo $form->label($model,'title',array('class'=>'inline')); ?>
        <?php echo CHtml::textField('Videos[title]', $vid_arr['title'], array('id'=>'video_title', 'maxlength'=>255)); ?>
    </div>    
    <div class="row row-spaced">
        <?php echo $form->label($model,'genre',array('class'=>'inline')); ?>
        <?php echo CHtml::dropDownList('Videos[genre]',$vid_arr['genre'], CHtml::listData(Genre::model()->findAll(), 'id', 'name'), array('empty'=>'Any')); ?>
    </div>    
    <div class="row row-spaced">
        <?php echo $form->label($model,'category',array('class'=>'inline')); ?>
        <?php echo CHtml::dropDownList('Videos[category]',$vid_arr['category'], CHtml::listData(Category::model()->findAll(), 'id', 'name'), array('empty'=>'Any')); ?>        
    </div>    
    <div class="row row-spaced">
        <?php echo $form->label($model,'age_range',array('class'=>'inline')); ?>        
        <?php echo CHtml::dropDownList('Videos[age]',$vid_arr['age'], CHtml::listData(Agerange::model()->findAll(), 'id', 'range'), array('empty'=>'Any')); ?>                
    </div>    
    <div class="row row-spaced buttons">
        <?php echo CHtml::submitButton('Search',array('class' => 'submitbtnclass')); ?>
    </div>

<?php $this->endWidget(); ?>
        
        <?php
        
//        echo CHtml::link($ssLinkName, $ssLinkUrl, array("class" => "block add"));
      
        
        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'videos-grid',
            'dataProvider' => $dataProvider,
            'afterAjaxUpdate' => 'js:bindColorbox',
            //'filter' => $model,
            'columns' => array(                    
                //'title',
                array(
                        'type'=>'raw',
                        'header'=>'Title',
                        'value'=>'CHtml::link($data->title, Yii::app()->createUrl(\'admin/classes/watchVideo\', array(\'iframe_code\' => base64_encode($data->iframe_code), \'description\' => base64_encode($data->description))), array(\'class\' => "ajax ", \'onclick\' => \'_gaq.push([\\\'_trackEvent\\\', \\\'Videos\\\', \\\'Play\\\', \\\'\' . addslashes($data->title) . \'\\\']); js:publisOnFb("\' . Yii::app()->createAbsoluteUrl(\'/site/watchVideoPublisFb\', array(\'id\' => \'93\')) . \'");\'))',                                                                  
                ),
                 array(
                        'header'=>'Genre',
                        'value'=>'($data->genre_name!=null) ? $data->genre_name : null',                        
                ),
                
                array(
                        'header'=>'Category',
                        'value'=>'($data->category_name!=null) ? $data->category_name : null',
                ),
                array(
                        'header'=>'Age range',
                        'value'=>'($data->age_range_name!=null) ? $data->age_range_name : null',
                )


            )
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
    function publisOnFb(ssVideoUrl) {
	return true;
        /*FB.init({appId: '<?php //echo Yii::app()->params['FACEBOOK_APPID'];      ?>',
            status: true,
            cookie: true,
            xfbml: true,
            oauth: true
        });*/
        FB.login(function(response) {
            if (response.authResponse) {
                //var access_token = response.authResponse.accessToken;
                FB.api(
                        "/me/video.watches",
                        "POST",
                        {
                            "video": 'http://inheritx.dnsdynamic.com:8590/tsd_live/publish/93',
                            //"video": 'http://www.twinklestardance.com/fb_watch.php',
                            'fb:explicitly_shared': true
                        },
                function(response) {
                    //alert(JSON.stringify(response));
                    console.log(JSON.stringify(response));
                }
                );
            } else {
                console.log('User cancelled login or did not fully authorize.');
            }
        }, {scope: 'publish_actions'});
    }    
</script>

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
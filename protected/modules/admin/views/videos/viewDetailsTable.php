<?php
$this->breadcrumbs = array(
    "<font>&nbsp;</font>" . Videos::label(2) . "<span>&nbsp;</span>" => array('class' => 'two', 'url' => array('index')),
    $oModelPackgeSub->name => array('class' => 'display two active', 'label' => "<font>&nbsp;</font>" . $oModelPackgeSub->name . "<span>&nbsp;</span>")
);

$vid_arr=Yii::app()->getRequest()->getParam('Videos');
$ssLinkName = "<span>" . CHtml::image(Yii::app()->request->baseUrl . "/images/icon/updates_available.png") . "</span><font>Updates Available</font><div class='numb'>" . $snTotalAvailableVideo . "</div>";
$ssLinkParams = (Yii::app()->getRequest()->getParam('package_id')) ? array('id' => $snPackageSubID, 'type' => $ssType, 'package_id' => Yii::app()->getRequest()->getParam('package_id')) : array('id' => $snPackageSubID, 'type' => $ssType);
$ssLinkUrl = ($snTotalAvailableVideo > 0 && $ssType != "Package") ? Yii::app()->createUrl("admin/videos/chooseVideoToAddYourSubscription", $ssLinkParams) : "javascript:void(0);";

$this->menu = array(
    array('label' => Yii::t('app', 'Switch to tile view'), 'url' => array('/user/videos/'.$ssLinkParams["id"].'/'.$ssLinkParams["type"])),        
);
?>

<div class="middle">
    <div class="fix videos">
        
        <h1>Search videos</h1>
<?php
        $model = new Videos('search');
$form=$this->beginWidget('CActiveForm', array(
    'action'=>'/user/videos/vtable/'.$ssLinkParams["id"].'/'.$ssLinkParams["type"],
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
                        'value'=>'CHtml::link($data->title, Yii::app()->createUrl(\'admin/videos/watchVideo\', array(\'iframe_code\' => base64_encode($data->iframe_code), \'description\' => base64_encode($data->description))), array(\'class\' => "ajax play", \'onclick\' => \'_gaq.push([\\\'_trackEvent\\\', \\\'Videos\\\', \\\'Play\\\', \\\'\' . addslashes($data->title) . \'\\\']); js:publisOnFb("\' . Yii::app()->createAbsoluteUrl(\'/site/watchVideoPublisFb\', array(\'id\' => \'93\')) . \'");\'))',                                                                  
                ),
                 array(
                        'header'=>'Genre',
                        'value'=>'($data->genreRel!=null) ? $data->genreRel->name : null',
                        //'filter'=> CHtml::activeTextField($model, 'genreRel'),
                ),
                array(
                        'header'=>'Category',
                        'value'=>'($data->categoryRel!=null) ? $data->categoryRel->name : null',
                ),
                array(
                        'header'=>'Age range',
                        'value'=>'($data->agerangeRel!=null) ? $data->agerangeRel->range : null',
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

<head>
    <style type="text/css">
        #video-add.submitbtnclass {
            padding: 10px;
            float: left;
            height: 39px !important;
            line-height: normal !important;
            border-radius: 3px !important;
            font: bold 13px Arial;
            color: #fff;
            display: block;
            position: absolute;
            top: 5px;
        }
    </style>
</head>

<?php

$this->breadcrumbs = array(
    Yii::t('app', 'Add ') . Videos::label(2) => array('class' => 'display two active', 'label' => "<font>&nbsp;</font>" . Yii::t('app', 'Add ') . Videos::label(2) . "<span>&nbsp;</span>")
);

$video_title = (isset($_GET['Videos']) && isset($_GET['Videos']['title']) && !empty($_GET['Videos']['title'])) ? $_GET['Videos']['title'] : '';
$video_genre = (isset($_GET['Videos']) && isset($_GET['Videos']['genre']) && !empty($_GET['Videos']['genre'])) ? $_GET['Videos']['genre'] : '';
$video_category = (isset($_GET['Videos']) && isset($_GET['Videos']['category']) && !empty($_GET['Videos']['category'])) ? $_GET['Videos']['category'] : '';
$video_age = (isset($_GET['Videos']) && isset($_GET['Videos']['age']) && !empty($_GET['Videos']['age'])) ? $_GET['Videos']['age'] : '';

$this->menu = array(
    array('label' => Yii::t('app', 'Switch to tile view'), 'url' => array('/user/classes/addVideos/'.Yii::app()->getRequest()->getParam('id'))),      
);

?>

<div class="middle">
    <div class="fix videos">
        
        <h1>Search videos</h1>
<?php
        $model = new Videos('search');
        $form=$this->beginWidget('CActiveForm', array(
            'method'=>'get',
        )); 
?>

    <div class="row row-spaced">
        <?php echo $form->label($model,'title',array('class'=>'inline')); ?>
        <?php echo CHtml::textField('Videos[title]', $video_title, array('id'=>'video_title', 'maxlength'=>255)); ?>
    </div>    
    <div class="row row-spaced">
        <?php echo $form->label($model,'genre',array('class'=>'inline')); ?>
        <?php echo CHtml::dropDownList('Videos[genre]',$video_genre, CHtml::listData(Genre::model()->findAll(), 'id', 'name'), array('empty'=>'Any')); ?>
    </div>    
    <div class="row row-spaced">
        <?php echo $form->label($model,'category',array('class'=>'inline')); ?>
        <?php echo CHtml::dropDownList('Videos[category]',$video_category, CHtml::listData(Category::model()->findAll(), 'id', 'name'), array('empty'=>'Any')); ?>        
    </div>    
    <div class="row row-spaced">
        <?php echo $form->label($model,'age_range',array('class'=>'inline')); ?>        
        <?php echo CHtml::dropDownList('Videos[age]',$video_age, CHtml::listData(Agerange::model()->findAll(), 'id', 'range'), array('empty'=>'Any')); ?>                
    </div>    
    <div class="row row-spaced buttons">
        <?php echo CHtml::submitButton('Search',array('class' => 'submitbtnclass')); ?>
    </div>

<?php $this->endWidget(); ?>
        
        <?php
        
        $this->beginWidget('GxActiveForm', array(
            'id' => 'assign-video-form',
            'enableAjaxValidation' => false
        ));

        echo GxHtml::submitButton(Yii::t('app', 'Done Adding'), array('id' => 'video-add', 'class' => 'submitbtnclass'));

        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'videos-grid',
            'dataProvider' => $dataProvider,
            'afterAjaxUpdate' => 'js:bindColorbox',
            //'filter' => $model,
            'columns' => array(
                "checkboxes" => array(
                    'class'               => 'CCheckBoxColumn',
                    'selectableRows'      => 3,
                    'checkBoxHtmlOptions' => array('class' => 'itemcheck'),
                    'value'               => '$data["id"]',
                ),                  
                array(
                        'name' => 'title',
                        'header'=>'Title',
                        'value'=>'$data["title"]',
                ),
                array(
                        'name' => 'genre',
                        'header'=>'Genre',
                        'value'=>'$data["genre_name"]',
                ),
                array(
                        'name' => 'category',
                        'header'=>'Category',
                        'value'=>'$data["category_name"]',
                ),
                array(
                        'name' => 'age_range',
                        'header'=>'Age range',
                        'value'=>'$data["age_range"]',
                ),
            )
        ));

        $this->endWidget();
        ?>
        <div class="clear"></div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() 
    {
       $(".ajax").colorbox();
       $('#videos-grid_ccheckboxes_all').hide();
    });
    function bindColorbox() {
        $(".ajax").colorbox();
        $('#videos-grid_ccheckboxes_all').hide();
    }
    function publisOnFb(ssVideoUrl) {
	return true;
        /*FB.init({appId: '<?php //echo Yii::app()->params['FACEBOOK_APPID'];      ?>',
            status: true,
            cookie: true,
            xfbml: true,
            oauth: true
        });*/
        FB.login(function(response) 
        {
            if (response.authResponse) 
            {
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
            } 
            else 
            {
                console.log('User cancelled login or did not fully authorize.');
            }
        }, {scope: 'publish_actions'});
    }    
</script>

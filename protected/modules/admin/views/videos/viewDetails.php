<?php
$this->breadcrumbs = array(
    "<font>&nbsp;</font>" . Videos::label(2) . "<span>&nbsp;</span>" => array('class' => 'two', 'url' => array('index')),
    $oModelPackgeSub->name => array('class' => 'display two active', 'label' => "<font>&nbsp;</font>" . $oModelPackgeSub->name . "<span>&nbsp;</span>")
);

$ssLinkName = "<span>" . CHtml::image(Yii::app()->request->baseUrl . "/images/icon/updates_available.png") . "</span><font>Updates Available</font><div class='numb'>" . $snTotalAvailableVideo . "</div>";
$ssLinkParams = (Yii::app()->getRequest()->getParam('package_id')) ? array('id' => $snPackageSubID, 'type' => $ssType, 'package_id' => Yii::app()->getRequest()->getParam('package_id')) : array('id' => $snPackageSubID, 'type' => $ssType);
$ssLinkUrl = ($snTotalAvailableVideo > 0 && $ssType != "Package") ? Yii::app()->createUrl("admin/videos/chooseVideoToAddYourSubscription", $ssLinkParams) : "javascript:void(0);";

$this->menu = array(
    array('label' => Yii::t('app', 'Switch to list view'), 'url' => array('/user/videos/vtable/'.$ssLinkParams["id"].'/'.$ssLinkParams["type"])),        
);
?>

<div class="middle">
    <div class="fix videos">
        <?php
        
        echo CHtml::link($ssLinkName, $ssLinkUrl, array("class" => "block add"));

        $this->widget('zii.widgets.CListView', array(
            'dataProvider' => $dataProvider,
            'itemView' => '_view_details',
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
    /*
     function publisOnFb(ssVideoUrl) {
     
     console.log('Facebook Open Graph Video Watch In-Process');
     return false;        
     FB.login(function (response) {
     if (response.authResponse) {
     var smAccessToken = response.authResponse.accessToken;
     FB.api(
     'me/video.watches',
     'post',
     {
     movie: "http://samples.ogp.me/453907197960619"
     //video: ssVideoUrl
     },
     function(response) {
     console.log(JSON.stringify(response));
     }
     );
     } else {
     console.log('User cancelled login or did not fully authorize.');
     }
     }, {scope: 'publish_actions'});       
     }*/
</script>

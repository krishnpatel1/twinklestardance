<?php
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.carouFredSel-6.2.0-packed.js');
?>
<style>
    .image_carousel {
        padding: 15px 0 15px 40px;
        position: relative;
    }
    .image_carousel img {       
        display: block;
        height: 91px;
        max-height: 91px;
        max-width: 161px;
        width: 161px;
    }
    .image_carousel .caroufredsel_wrapper a{
        background: none repeat scroll 0 0 #333333;
        border-radius: 10px 10px 10px 10px;
        float: left;
        height: 141px;
        margin: 0 15px;
        padding: 12px 12px 0;
        width: 161px;  
    }
    .image_carousel .caroufredsel_wrapper p{
        color: #FFFFFF;
        font-family: Arial,Helvetica,sans-serif;
        font-size: 12px;
        line-height: 18px;
        margin-top: 7px;
        text-align: center;
    }   
    a.prev {
        background: url("../images/icon/next.png") no-repeat scroll 0 0 transparent;
        cursor: pointer;
        display: block;
        height: 95px;
        left: -22px;
        margin: 0 0 0 30px;
        top: 45px;
        width: 27px;
        position: absolute
    }
    a.next {
        background: url("../images/icon/prev.png") no-repeat scroll 0 0 transparent;
        cursor: pointer;
        display: block;
        height: 95px;
        margin: 0 30px 0 0;
        right: -22px;
        top: 45px;
        width: 27px;
        position: absolute
    }

    a.prev span, a.next span {
        display: none;
    }
    .pagination {
        text-align: center;
    }
    .pagination a {
        background: url(../images/miscellaneous_sprite.png) 0 -300px no-repeat transparent;
        width: 15px;
        height: 15px;
        margin: 0 5px 0 0;
        display: inline-block;
    }
    .pagination a.selected {
        background-position: -25px -300px;
        cursor: default;
    }
    .pagination a span {
        display: none;
    }
    .clearfix {
        float: none;
        clear: both;
    }
    .ifrmClass{
        border:5px solid grey; 
        padding:2px; 
        background-color:grey;
    }
</style>


<div class="inner_page">
    <div class="fix">
        <div class="newsletter_info">
            <h2>Videos
                <div class="button2">
                    <?php echo CHtml::button('Sign Up', array('onclick' => 'js:openColorBox("' . CController::createUrl("index/joinNewsletter") . '",400,300);return false;', 'class' => 'ajax')); ?>
                </div>
                <div class="text-sub">
                    Join our Mailing List for FREE offers and tips on how to grow your studio with Twinkle Bear
                </div>
            </h2>
        </div>
    </div>
    <div class="ad-gallery" id="gallery">
        <div class="slider videos">
            <div class="white">
                <div class="ad-image-wrapper">
                    <table broder="0">
                        <tr>
                            <td class="fb-share-icon" style="float:right;">
                                <span id="fb_share_title" style="display:none;"></span>
                                <span id="fb_share_url" style="display:none;"></span>
                                <span id="fb_share_image" style="display:none;"></span>
                                <?php echo CHtml::image(Yii::app()->baseUrl . "/images/facebook_share.gif", '', array('onclick' => 'fb_share();', 'style' => 'cursor:pointer; height:30px; margin-top:5px;')); ?>
                            </td>

                        </tr>
                        <tr>
                            <td class="ad-image" valign="middle" style="text-align: center;width: 800px; height: 600px; top: 35px; padding: 0 80px;">
                                <div style="float:left;margin-top: -85px;"><h3></h3></div>
                                <div id="showSampleVideo"></div>                                
                            </td>                            
                        </tr>
                    </table>
                    <img src="<?php echo Yii::app()->baseUrl ?>/images/icon/loader.gif" class="ad-loader" style="display: none;">                    
                </div>
            </div>
        </div> 
        <div class="fix">
            <div class="image_carousel">
                <div id="foo2">
                    <?php
                    $snI = 0;
                    foreach ($omSampleVideos as $omDataSet):
                        $ssVideoUrl = $omDataSet->iframe_code;
                        $ssVideoUrl = str_replace('<iframe ', '<iframe class="ifrmClass"', $ssVideoUrl);

                        $ssImage = CHtml::image(UtilityHtml::getVideoImage($omDataSet->image_url), '', array('height' => '140', 'width' => '140'));
                        $ssText = (strlen($omDataSet->title) > Yii::app()->params['max_length_char_to_dispaly']) ? substr($omDataSet->title, 0, Yii::app()->params['max_length_char_to_dispaly']) . '...' : $omDataSet->title;
                        $ssUniqueVideoURL = Yii::app()->createUrl('/site/samples', array('id' => base64_encode($omDataSet->id)));
                        echo CHtml::link($ssImage . '<p>' . $ssText . '</p>', $ssUniqueVideoURL, array('title' => $omDataSet->title, 'onclick' => 'playVideo("' . urlencode($ssVideoUrl) . '","' . $ssUniqueVideoURL . '");_gaq.push([\'_trackEvent\', \'Sample Videos\', \'Play\', \'' . $omDataSet->title . '\']);return false;'));
                        ?>

                        <?php
                        if ($snI == 0):
                            $ssSelectedVideoUrl = ($omSelectedVideo) ? $omSelectedVideo->iframe_code : $ssVideoUrl;
                            $ssSelectedVideoUrl = str_replace('<iframe ', '<iframe class="ifrmClass"', $ssSelectedVideoUrl);

                            $smFbShareImageUrl = ($omSelectedVideo) ? UtilityHtml::getVideoImage($omSelectedVideo->image_url) : UtilityHtml::getVideoImage($omDataSet->image_url);
                            $ssFbText = ($omSelectedVideo) ? $omSelectedVideo->title : $omDataSet->title;
                            $smFbShareUrl = ($omSelectedVideo) ? Yii::app()->createAbsoluteUrl('/site/samples', array('id' => base64_encode($omSelectedVideo->id))) : Yii::app()->createAbsoluteUrl('/site/samples', array('id' => base64_encode($omDataSet->id)));
                            ?>
                            <script type="text/javascript">
                                $('#showSampleVideo').html('<?php echo $ssSelectedVideoUrl; ?>');
                                $('#fb_share_image').html('<?php echo $smFbShareImageUrl; ?>');
                                $('#fb_share_title').html('<?php echo $ssFbText; ?>');
                                $('#fb_share_url').html('<?php echo $smFbShareUrl; ?>');
                            </script>
                        <?php endif; ?>
                        <?php
                        $snI++;
                    endforeach;
                    ?>

                </div>
                <div class="clearfix"></div>
                <a class="prev" id="foo2_prev" href="#"><span>prev</span></a>
                <a class="next" id="foo2_next" href="#"><span>next</span></a>
                <div class="pagination" id="foo2_pag"></div>
            </div>
        </div>
    </div>
</div>
<!-- Facebook JS Init Start -->
<?php
//if (Yii::app()->user->isGuest):

    $smFbAppID = Common::getFacebookID(); //Yii::app()->params['FACEBOOK_APPID'];
    $script = <<<EOL

        window.fbAsyncInit = function() {
            FB.init({   appId: '{$smFbAppID}', 
                        status: true, 
                        cookie: true,
                        xfbml: true,
                        oauth: true
            });
        };

        (function(d){var e,id = "fb-root";if( d.getElementById(id) == null ){e = d.createElement("div");e.id=id;d.body.appendChild(e);}}(document));
        (function(d){var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];if (d.getElementById(id)) {return;} js = d.createElement('script'); js.id = id; js.async = true; js.src = "//connect.facebook.net/en_US/all.js"; ref.parentNode.insertBefore(js, ref); }(document));        
EOL;

    Yii::app()->clientScript->registerScript('facebook-connect', $script, CClientScript::POS_END);
//endif;
?>
<script type="text/javascript">

    function fb_share() {

        ssTitle = $('#fb_share_title').html();
        ssImage = $('#fb_share_image').html();
        ssUrl = $('#fb_share_url').html();

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
    $("#foo2").carouFredSel({
        circular: false,
        infinite: false,
        auto: false,
        prev: {
            button: "#foo2_prev",
            key: "left"
        },
        next: {
            button: "#foo2_next",
            key: "right"
        },
        pagination: false
    });

    function playVideo(ssIframeCode, ssVideoUniqueURL) {
        $('#showSampleVideo').html(decodeURIComponent((ssIframeCode + '').replace(/\+/g, '%20')));
        top.location.href = ssVideoUniqueURL;
    }
</script>

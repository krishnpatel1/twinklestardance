<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />        
        <!-- blueprint CSS framework -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
        <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
        <![endif]-->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/stylesheet.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style2.css" />                

        <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>  
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.min.js" ></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.8.3.js" ></script>        
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/custom-form-elements.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/common.js"></script>
        <?php
        $baseUrl = Yii::app()->baseUrl;
        $cs = Yii::app()->getClientScript();
        $cs->registerScriptFile($baseUrl . '/js/colorbox/jquery.colorbox.js');
        $cs->registerCssFile($baseUrl . '/css/colorbox/colorbox.css');
        ?>
        <script type="text/javascript">
            $(document).ready(function() {
                $(function() {
                    $('.menu li').hover(
                            function() {
                                //show its submenu
                                $('ul', this).stop().slideDown(200);

                            },
                            function() {
                                //hide its submenu
                                $('ul', this).stop().slideUp(200);
                                //$('ul', this).stop().hide();
                            }
                    );

                });
            });
        </script>
        <!-- Event Tracking Initialization -->
        <script type="text/javascript">

            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-44470425-1']);
            _gaq.push(['_trackPageview']);

            _gaq.push(['t2._setAccount', 'UA-44470425-1']);
            _gaq.push(['t2._setDomainName', 'twinklestardance.com']);
            _gaq.push(['t2._trackPageview']);

            (function() {
                var ga = document.createElement('script');
                ga.type = 'text/javascript';
                ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(ga, s);
            })();
        </script>
        <!-- Event Tracking Initialization End -->
        <!-- Google Analytics Tracking Code -->
        <script type="text/javascript">

            (function(i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function() {

                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)

            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-44470425-1', 'twinklestardance.com');
            ga('send', 'pageview');

        </script>
        <!-- End Google Analytics Tracking Code -->
        <!-- Facebook JS Init Start -->
        <?php /*
        if (!Yii::app()->user->isGuest):

            $smFbAppID = Yii::app()->params['FACEBOOK_APPID'];
            $script = <<<EOL

        window.fbAsyncInit = function() {
            FB.init({   appId: '{$smFbAppID}', 
                        status: true, 
                        cookie: true,
                        xfbml: true,
                        oauth: true
            });

            var c = document.getElementById("logout");
            if(c){
                c.onclick = function(){
                    FB.logout();
                }
            }
        };

        (function(d){var e,id = "fb-root";if( d.getElementById(id) == null ){e = d.createElement("div");e.id=id;d.body.appendChild(e);}}(document));
        (function(d){var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];if (d.getElementById(id)) {return;} js = d.createElement('script'); js.id = id; js.async = true; js.src = "//connect.facebook.net/en_US/all.js"; ref.parentNode.insertBefore(js, ref); }(document));        
EOL;

            Yii::app()->clientScript->registerScript('facebook-connect', $script, CClientScript::POS_END);
        endif;*/
        ?>
        <!-- Facebook JS Init End -->

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>

    <body>

        <div id="main">
            <div class="header">
                <div class="fix">
                    <div class="flash_message">
                        <?php
                        foreach (Yii::app()->user->getFlashes() as $key => $message) {
                            echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
                        }
                        ?>
                    </div> 
                    <div class="top_nav">
                        <a href="http://www.twinklestardance.com" title="Twinkle Star Dance" class="fl logo"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo.png" alt="" height="101"/></a>
                        <div class="fr">
                            <?php if (Yii::app()->user->isGuest): ?>
                                <div class="call_us fr">
                                    <h1><font>Call Now:</font> 925.583.2830</h1>
                                    <span>Monday - Friday 9:00AM - 5:00PM PST</span>
                                </div>
                            <?php endif; ?>
                            <div class="clear"></div>
                            <div class="fr welcome">
                                <?php echo CHtml::encode(AdminModule::getWelcomeText()); ?>
                            </div> 
                            <div class="social">
                                <?php if (Yii::app()->user->isGuest): ?>
                                    <div class="fl">
                                        <a href="https://twitter.com/TwnkleStarDance" title="" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icon/twit.png" /></a>
                                        <a href="http://www.facebook.com/TwinkleStarDance" title="" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icon/facebook.png" /></a>
                                        <a href="http://www.linkedin.com/pub/tiffany-henderson/43/955/a49" title="" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icon/likedin.png" /></a>
                                        <a href="http://www.youtube.com/user/twinklestarsdance" title="" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icon/youtube.png" /></a>
                                        <a href="http://twinklestardance.tumblr.com/" title="" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icon/twitter.png" /></a>
                                        <a href="http://pinterest.com/twnklestarDance/" title="" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icon/pay.png" /></a>
                                    </div>
                                <?php endif; ?>
                                <div class="fr">
                                    <?php
                                    if (!Yii::app()->user->isGuest):
                                        echo CHtml::link(Yii::t('app', 'Logout'), array('/'),array('id' => 'logout', 'class' => 'login', 'onclick' => 'FB.logout();'));
                                        if (!AdminModule::isAdmin() && !AdminModule::isInstructor()):
                                            echo CHtml::link(Yii::t('app', 'Dashboard'), array('/admin/index/index'), array('class' => 'login'));
                                        else:
                                            echo CHtml::link(Yii::t('app', 'Dashboard'), array('/admin/index/index'), array('class' => 'logout'));
                                        endif;
                                    endif;
                                    ?>
                                    <?php if (!AdminModule::isAdmin() && !AdminModule::isInstructor() && !Yii::app()->user->isGuest): ?>
                                        <a href="<?php echo Yii::app()->createUrl('site/cart'); ?>" class="cart">Cart</a>
                                    <?php endif; ?>

                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                </div>                
            </div>
            <div class="middle">               
                <?php echo $content; ?>               
            </div>
            <div class="footer">
                <div class="top_nav">
                    <div class="fix">
                        <div class="block">
                            <ul>
                                <li><?php echo CHtml::link(Yii::t('app', 'Home'), array('index/index')); ?></li>
                                <li><?php echo CHtml::link(Yii::t('app', 'About'), array('index/cms', 'id' => 'about_us')); ?></li>
                                <li><?php echo CHtml::link(Yii::t('app', 'Samples'), array('site/samples')); ?></li>
                                <?php if (!Yii::app()->user->isGuest): ?>                                
                                    <li><?php echo CHtml::link(Yii::t('app', 'Settings'), array('user/settings')); ?></li>                              
                                <?php endif; ?>    
                                <li><?php echo CHtml::link(Yii::t('app', 'Subscriptions'), array('site/subscriptions')); ?></li>                              
                                <li><?php echo CHtml::link(Yii::t('app', 'Contact'), array('site/contact')); ?></li>
                            </ul>
                        </div>
                        <div class="block">
                            <ul>
                                <li><?php echo CHtml::link(Yii::t('app', 'FAQ'), array('index/cms', 'id' => 'faqs')); ?></li>
                                <li><?php echo CHtml::link(Yii::t('app', 'Privacy Policy'), array('index/cms', 'id' => 'privacy_policy')); ?></li>
                                <li><?php echo CHtml::link(Yii::t('app', 'Terms of Use'), array('index/cms', 'id' => 'term_of_use')); ?></li>
                            </ul>
                        </div>
                        <div class="block contact">
                            <p>Twinkle Star Dance™<br />
                                4046 East Avenue<br />
                                Livermore, CA 94550</p>
                            <p>Phone: 888 380 5299<br />
                                Email: <a href="mailto:info@twinklestardance.com">info@twinklestardance.com</a></p>
                            <div class="fl">
                                <a href="https://twitter.com/TwnkleStarDance" title="" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icon/twit.png" /></a>
                                <a href="http://www.facebook.com/TwinkleStarDance" title="" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icon/facebook.png" /></a>
                                <a href="http://www.linkedin.com/pub/tiffany-henderson/43/955/a49" title="" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icon/likedin.png" /></a>
                                <a href="http://www.youtube.com/user/twinklestarsdance" title="" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icon/youtube.png" /></a>
                                <a href="http://twinklestardance.tumblr.com/" title="" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icon/twitter.png" /></a>
                                <a href="http://pinterest.com/twnklestarDance/" title="" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icon/pay.png" /></a>
                            </div>
                        </div>
                        <div class="clear"></div>
                        <div class="block">&nbsp;</div>
                        <div class="block copyright">
                            © 2012 <a href="#">Twinkle Star Dance.</a> All rights reserved.
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main4.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.js"></script>
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>

    <body  class="loginpage">
        <div id="header">
            <div class="content">
                <div id="logo">
<!--                    <div class="header-left">
                        <img src="<?php //echo Yii::app()->request->baseUrl; ?>/images/logo.png" alt="" height="30" />
                    </div>-->
                </div>
            </div>
        </div>
        <!-- header -->
        <div class="login_content">
            <div class="content">
                <?php
                foreach (Yii::app()->admin->getFlashes() as $key => $message) {
                    echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
                }
                ?>
                <?php echo $content; ?> 
            </div>
        </div>
        <!-- footer -->
        <div id="footer"> Copyright &copy; <?php echo date('Y'); ?> by <?php echo SystemConfig::getValue('site_name') ?>. All Rights Reserved.<br/>
        </div>
        <!-- page -->
    </body>
</html>
<!-- Phase-II: Add Google Analytics Code -->
<script>

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
<!-- End Google Analytics Code -->
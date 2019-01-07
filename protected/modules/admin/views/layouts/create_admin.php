<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/popup.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.js"></script>
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <?php
        $baseUrl = Yii::app()->baseUrl;
        $cs = Yii::app()->getClientScript();
        $cs->registerScriptFile($baseUrl . '/js/colorbox/jquery.colorbox.js');
        $cs->registerCssFile($baseUrl . '/css/colorbox/colorbox.css');
        ?>
    </head>

    <body>
        <div class="container" id="page">
            <!-- breadcrumbs Ends -->
            <div class="maincont"> 
                <?php
                foreach (Yii::app()->user->getFlashes() as $key => $message) {
                    echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
                }
                ?>
                <div class="content_left">
                    <div id="sidebar">
                        <?php
                        $this->beginWidget('zii.widgets.CPortlet', array(
                            'title' => 'Operations',
                        ));
                        $this->widget('zii.widgets.CMenu', array(
                            'items' => $this->menu,
                            'htmlOptions' => array('class' => 'operations'),
                        ));
                        $this->endWidget();
                        ?>
                    </div>
                    <!-- sidebar --> 
                </div>
                <div  class="content_right"> <?php echo $content; ?></div>
            </div>
        </div>

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
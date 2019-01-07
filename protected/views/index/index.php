<?php
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.flexslider.js');
?>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $(function() {
            //SyntaxHighlighter.all();
        });
        $('.flexslider').flexslider({
            animation: "fade",
            start: function(slider) {
                $('body').removeClass('loading');
            }
        });
    });
</script>
<style>
    /*  Change flex control padding based on number of items in the carousel.
        The formula is (960 - 30n) / 2 */
    .flex-control-nav {
        padding-left: 375px;
    }
</style>
<div class="slider">
    <div class="flexslider">
        <ul class="slides">

			
            <!--li><a href="http://www.twinklestardance.com/site/subscriptions"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/banner/TSD-Web-Header-090413.jpg" /></a></li>
            <li><a href="http://www.twinklestardance.com/site/subscriptions"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/banner/TSD-Home-3.jpg" /></a></li>
            <li><a href=""><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/banner/TSD-2016-User-Conference-FB-COVER-091615.jpg" /></a></li>
            <li><a href="http://www.twinklestardance.com/site/subscriptions"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/banner/TSD-Home-5.jpg" /></a></li>
            <li><a href="https://www.revolutiondance.com/revolution-dancewear-is-pleased-to-supply-the-official-uniform-of-the-twinkle-star-dance----program--pages-342.php" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/banner/TSD-Web-Header-060415.png" /></a></li>
            <li><a href="https://www.costumegallery.net/products/categories/twinkle-star-dance/" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/banner/TSD-Web-Header-COSTUMEGALLERY-070115.jpg" /></a></li>
            <li><a href="http://www.dancestudioowner.com/public/Twinkle-Star-Dance-Curriculum.cfm" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/banner/TSD-Web-Header-DSO-070615.jpg" /></a></li>
            <li><a href="http://goo.gl/forms/LguA6mr33x"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/banner/TSD-Winter-Weekend-WEB-090515.jpg" /></a></li-->
            <?php 
            $allImgs = Image::model()->findAll(array('order'=>'position'));
            foreach($allImgs as $img) 
            {                                 
                echo  "<li><a href=\"".$img['imglink']."\"><img src=\"".Yii::app()->request->baseUrl."/images/banner/".$img['url']."\"/></a></li>";
            }
            
            ?>

        </ul>
        
    </div>
</div>
<div class="fix">
    <div class="block left">
        <h1>Here is how we will improve your studio!</h1>
        <ul class="sale">
            <li>-Increase your school's revenue by $113,000 <a class="ajax cboxElement" href="#" onclick="js:openColorBox('http://www.twinklestardance.com/learnHow.php',550,450);return false;">(Click to learn how)</a></li>
            <li>-Eliminate the need to choreograph new material each season</li>
            <li>-Eliminate the need to search for and edit new music</li>
            <li>-Eliminate the need to train new instructor staff</li>            
        </ul>
        <!--<ul class="sale">
            <li>-Increase class picture revenue by $700</li>
            <li>-Attract students to studio via increased word-of-mouth referrals</li>
            <li>-Eliminate the need to choreograph new material each season</li>
            <li>-Eliminate the need to search for and edit new music</li>
            <li>-Eliminate the need to train new instructor staff</li>
            <li class="note">*Based on the average experience at 7 Tiffany's Dance Academy locations.</li>
        </ul>-->
    </div>
    <div class="block right" id="sign-up-for-newsletter">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'news-letter-form',
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'validateOnChange' => false,
                'validateOnType' => false
            )
        ));
        ?>
        <div class="row"><h2 style="font-style: italic;">Join Our Mailing List</h2></div>
        <div class="row"><p>Receive free offers and learn how a recreational dance program will help your studio to grow.</p></div>
        <div class="row topmargin">
            <?php echo $form->textField($model, 'email', array('autocomplete' => 'off')); ?>
            <?php echo $form->error($model, 'email'); ?>
        </div>
        <div class="row topmargin">
            <?php echo CHtml::submitButton('Sign Up'); ?>
        </div>
        <?php $this->endWidget(); ?>        
    </div>
    <div class="clear">&nbsp;</div>
    <div class="block">
        <div class="nav">
            <div class="icon"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icon/subscribe.png" title=""/></div>
            <div class="details">
                <h2>Subscriptions</h2>
                <p>Please click <?php echo CHtml::link('Learn More', array('site/subscriptions')); ?> to be directed to our full list of Subscriptions.</p>
            </div>
        </div>
        <div class="nav">
            <div class="icon"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icon/videos.png" title=""/></div>
            <div class="details">
                <h2>Sample Videos</h2>
                <p>Please click <?php echo CHtml::link('Learn More', array('site/samples')); ?> to be directed to our list of sample videos.</p>
            </div>
        </div>
        <div class="nav nav_last">
            <div class="icon"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icon/contacts.png" title=""/></div>
            <div class="details">
                <h2>Contact Us</h2>
                <p>Please click <?php echo CHtml::link('Learn More', array('site/contact')); ?> to be directed to our contact page.</p>
            </div>
        </div>
        <div class="clear"></div>
    </div>
    <?php 
        $allTestimonials = Testimonial::model()->findAll(array('order'=>'sysposition'));    
        foreach($allTestimonials as $testimonial)             
        {?>            
    <div class="quote_area">
        <div class="user">
            <h5><?php echo $testimonial['name'];?></h5>
            <h6><?php echo $testimonial['position'];?></h6>
            <h6><?php echo $testimonial['institution'];?> </h6>
        </div>
        <div class="talkbubble">            
            <?php echo nl2br(htmlentities($testimonial['text'], ENT_QUOTES, 'UTF-8'));?>
        </div>
                    
        <div class="clear"></div>
    </div>
            
    <?php
        }
    ?>
    <!--div class="quote_area">
        <div class="user">
            <h5>Kim Wright</h5>
            <h6>Recreational Programs Director </h6>
            <h6>The Dance Zone </h6>
        </div>
        <div class="talkbubble">
            The Dance Zone in Henderson, NV loves the Twinkle Star Dance Program. Take a moment to read about their experience with the program in their own words!<br /><br />

            "We are pleased to be using the Twinkle Star program at The Dance Zone this year! We have found it to be a well-rounded, effective program for teaching technique to
            young dancers in a fun, accessible way! We have about 10 teachers teaching the Twinkle Stars program in over 50 recreational classes, for ages 2-10. <br /><br />

            We are excited about the cohesiveness that the program allows us to offer at our studio. It has been a good tool for opening a dialogue for the teachers, so that we
            can discuss what and how we are teaching in our classes and make sure we are all on the same page. Our teachers have been pleased to find that most of the techniques 
            and skills are things they were already doing and teaching, just presented in a new way. That has given them confidence in the syllabus as they have embarked on a new program.
            As the teachers become more familiar with the program, they are finding ways to use the program effectively, while still retaining their uniqueness as an individual instructor. <br /><br />

            It has been a good sales tool for the front desk as well, as they are able to explain to parents that every teacher in each class will be covering the same technique and the same syllabus. It helps when a parent can't get their first choice of teacher, to be able to explain that the other teachers will be teaching very similar things.
            <br /><br />
            It's nice to have fun, age-appropriate music and cute combos already prepared for teachers! The warm ups have given teachers a good place to start, with a base level of technique and moves that they can initially introduce. The classroom schedule and breakdown works great, and some of the ideas for the youngest dancers, such as Twinkle Bears and hula hoops, have been a huge success! Keep the videos and good ideas coming!
            <br /><br />
            Thanks and keep up the good work!
        </div>
        <div class="clear"></div>
    </div-->
</div>
<script type="text/javascript">
    $('#NewslettersUsers_email').each(function() {
        var default_value = 'Email';
        $(this).focus(function() {
            if (this.value == default_value) {
                this.value = '';
            }
        });
        $(this).blur(function() {
            if (this.value == '') {
                this.value = default_value;
            }
        });
    });
</script>
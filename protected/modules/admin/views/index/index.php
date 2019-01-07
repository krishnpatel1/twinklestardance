<?php $this->breadcrumbs = array(); ?>
<div class="middle_inner">
    <div class="fix">
        <?php
        $amMenus = Common::getDashboadMenusAsPerRole();

        if (count($amMenus) > 0) {
            foreach ($amMenus as $asValues) {
                $ssLInkName = "<span>" . CHtml::image($asValues['icon']) . "</span>";
                $ssLInkName .= $asValues['name'];
                echo CHtml::link($ssLInkName, $asValues['url'], array('class' => $asValues['class']));
            }
        }?>                
        <div class="clear"></div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function()
    {
        var actionURL = "<?php echo CController::createUrl('/user/subscription/check'); ?>";
        var ses_display_subscription = "<?php echo isset($_SESSION['display_subscription']) ? 1 : 0 ?>";
       
        $.ajax({
            url: actionURL,
            type: 'POST',
            success: function (result) 
            {
               if(result > 0 && ses_display_subscription == 0)
               {
                    var actionURL = "<?php echo CController::createUrl('/user/subscription/list'); ?>";

                    $.colorbox({
                                 href: actionURL,width: "840px",height: "500px",iframe: true,scrolling: false,
                                 scrolling:true,
                                 onClosed:function()
                                 {
                                    var actionURL = "<?php echo CController::createUrl('/user/classes/getClassesReport?classReportResult=1'); ?>";
                                    $.ajax({
                                              url: actionURL,
                                              type: 'POST',
                                              success: function (result) 
                                              {
                                                if(result > 0)
                                                {
                                                    var actionURL = "<?php echo CController::createUrl('/user/classes/getClassesReport?colorbox=1'); ?>";

                                                    $.colorbox({
                                                                   href: actionURL,width: "840px",height: "500px",iframe: true,scrolling: false,
                                                                   scrolling:true,
                                                               }); 
                                       
                                                    return false;
                                                }
                                              }
                                    });
                                }
                    }); 
              }
              else if(ses_display_subscription == 0)
              {
                  var actionURL = "<?php echo CController::createUrl('/user/classes/getClassesReport?classReportResult=1'); ?>";
                  $.ajax({
                            url: actionURL,
                            type: 'POST',
                            success: function (result) 
                            {
                              if(result > 0)
                              {
                                  var actionURL = "<?php echo CController::createUrl('/user/classes/getClassesReport?colorbox=1'); ?>";

                                  $.colorbox({
                                                 href: actionURL,width: "840px",height: "500px",iframe: true,scrolling: false,
                                                 scrolling:true,
                                             }); 
                     
                                  return false;
                              }
                            }
                  });
              }
            }
          });
    });     
</script>
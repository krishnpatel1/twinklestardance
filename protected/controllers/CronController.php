<?php

class CronController extends FrontCoreController 
{
    public function actionError() 
    {
        if ($error = Yii::app()->errorHandler->error) 
        {
            if (Yii::app()->request->isAjaxRequest)
            {
                echo $error['message'];
            }
            else
            {
                $this->render('error', $error);
            }
        }
    }

    public function actionSendMailClassesReport() 
    {
        $studio_usr_exp_class = Yii::app()->db->createCommand("SELECT DATEDIFF(c.end_date, CURDATE()) AS remaining_days,c.id,c.name,c.start_date,c.end_date,u.id as userid,u.studio_name,u.email FROM classes AS c INNER JOIN users u ON c.created_by=u.id WHERE DATE_FORMAT(c.end_date,'%Y-%m-%d') >= DATE_FORMAT(NOW(),'%Y-%m-%d') HAVING remaining_days = 7 OR remaining_days = 1 OR remaining_days = 0")->queryAll();

        $userid_key_arr = array();
        $user_class_arr = array();

        foreach ($studio_usr_exp_class as $key => $class) 
        {
            if(!empty($userid_key_arr) && in_array($class['userid'], $userid_key_arr))
            {
                $user_class_arr[$class['userid']][$key] = $class;
            }
            else
            {
                $userid_key_arr[$class['userid']][$key] =  $class;
            }
        }

        foreach ($userid_key_arr as $user_key => $user_classes) 
        {
            $today_expire_classes = array();
            $tomorrow_expire_classes = array();
            $next_week_expire_classes = array();

            if(!empty($user_classes))
            {
                foreach ($user_classes as $class_key => $studio_class) 
                {
                    if($studio_class['remaining_days'] == 0)
                    {
                        $today_expire_classes[] = $studio_class;
                    } 
                    else if($studio_class['remaining_days'] == 1)
                    {
                        $tomorrow_expire_classes[] = $studio_class;
                    } 
                    else 
                    {
                        $next_week_expire_classes[] = $studio_class;
                    }

                    $studio_email = $studio_class['email'];
                    $studio_name = ucfirst($studio_class['studio_name']);
                }

                if(!empty($today_expire_classes))
                {
                    $content_html = $this->renderPartial("/emailTemp/class_expire",array('expire_classes' => $today_expire_classes,'studio_name' => $studio_name,'expire_day_text'=> 'today'),true);

                    $omMessage = new YiiMailMessage; 
                    $omMessage->setTo($studio_email);
                    //$omMessage->setTo("jamal@inheritx.com");
                    $omMessage->setFrom('inx.email001@gmail.com');
                    $omMessage->setSubject("Alert! Your studio class expiring today"); 
                    $omMessage->setBody($content_html, 'text/html', 'utf-8');

                    $result = Yii::app()->mail->send($omMessage);
                }

                if(!empty($tomorrow_expire_classes))
                {
                    $content_html = $this->renderPartial("/emailTemp/class_expire",array('expire_classes' => $tomorrow_expire_classes,'studio_name' => $studio_name,'expire_day_text'=> 'tomorrow'),true);

                    $omMessage = new YiiMailMessage; 
                    $omMessage->setTo($studio_email);
                    //$omMessage->setTo("jamal@inheritx.com");
                    $omMessage->setFrom('inx.email001@gmail.com');
                    $omMessage->setSubject("Alert! Your studio class expiring tomorrow"); 
                    $omMessage->setBody($content_html, 'text/html', 'utf-8');

                    $result = Yii::app()->mail->send($omMessage);
                }

                if(!empty($next_week_expire_classes))
                {
                    $content_html = $this->renderPartial("/emailTemp/class_expire",array('expire_classes' => $next_week_expire_classes,'studio_name' => $studio_name,'expire_day_text'=> 'next week'),true);

                    $omMessage = new YiiMailMessage; 
                    $omMessage->setTo($studio_email);
                    //$omMessage->setTo("jamal@inheritx.com");
                    $omMessage->setFrom('inx.email001@gmail.com');
                    $omMessage->setSubject("Alert! Your studio class expiring next week"); 
                    $omMessage->setBody($content_html, 'text/html', 'utf-8');

                    $result = Yii::app()->mail->send($omMessage);
                }
            }
        }
    }

    public function actionSendMailSubscriptionExpire() 
    {
        $studio_usr_exp_subs = Yii::app()->db->createCommand("SELECT DATEDIFF(od.expiry_date, CURDATE()) AS remaining_days,od.id,od.start_date,od.expiry_date,od.amount,od.duration,u.id as userid,u.studio_name,u.email,ps.name as package_name FROM order_details AS od INNER JOIN orders o ON o.id = od.order_id INNER JOIN users u ON o.user_id=u.id INNER JOIN package_subscription ps ON ps.id=od.package_subscription_id WHERE o.payment_status = 1 AND od.is_deleted = 0 AND DATE_FORMAT(od.expiry_date,'%Y-%m-%d') >= DATE_FORMAT(NOW(),'%Y-%m-%d') HAVING remaining_days = 30 OR remaining_days = 7 OR remaining_days = 1 OR remaining_days = 0")->queryAll();

        $userid_key_arr = array();
        $user_subscription_arr = array();

        foreach ($studio_usr_exp_subs as $key => $subscription) 
        {
            if(!empty($userid_key_arr) && in_array($subscription['userid'], $userid_key_arr))
            {
                $user_subscription_arr[$subscription['userid']][$key] = $subscription;
            }
            else
            {
                $userid_key_arr[$subscription['userid']][$key] =  $subscription;
            }
        }

        foreach ($userid_key_arr as $user_key => $user_subscriptions) 
        {
            $today_expire_subscriptions = array();
            $tomorrow_expire_subscriptions = array();
            $next_week_expire_subscriptions = array();
            $next_month_expire_subscriptions = array();

            if(!empty($user_subscriptions))
            {
                foreach ($user_subscriptions as $class_key => $subscription) 
                {
                    if($subscription['remaining_days'] == 0)
                    {
                        $today_expire_subscriptions[] = $subscription;
                    } 
                    else if($subscription['remaining_days'] == 1)
                    {
                        $tomorrow_expire_subscriptions[] = $subscription;
                    }
                    else if($subscription['remaining_days'] == 7)
                    {
                        $next_week_expire_subscriptions[] = $subscription;
                    } 
                    else 
                    {
                        $next_month_expire_subscriptions[] = $subscription;
                    }

                    $studio_email = $subscription['email'];
                    $studio_name = ucfirst($subscription['studio_name']);
                }

                if(!empty($today_expire_subscriptions))
                {
                    $content_html = $this->renderPartial("/emailTemp/subscription_expire",array('expire_subscriptions' => $today_expire_subscriptions,'studio_name' => $studio_name,'expire_day_text'=> 'today'),true);

                    $omMessage = new YiiMailMessage; 
                    $omMessage->setTo($studio_email);
                    //$omMessage->setTo("jamal.inheritx@gmail.com");
                    $omMessage->setFrom('inx.email001@gmail.com');
                    $omMessage->setSubject("Alert! Your subscription plan's expiring today"); 
                    $omMessage->setBody($content_html, 'text/html', 'utf-8');

                    $result = Yii::app()->mail->send($omMessage);
                }

                if(!empty($tomorrow_expire_subscriptions))
                {
                    $content_html = $this->renderPartial("/emailTemp/subscription_expire",array('expire_subscriptions' => $tomorrow_expire_subscriptions,'studio_name' => $studio_name,'expire_day_text'=> 'tomorrow'),true);

                    $omMessage = new YiiMailMessage; 
                    $omMessage->setTo($studio_email);
                   // $omMessage->setTo("jamal.inheritx@gmail.com");
                    $omMessage->setFrom('inx.email001@gmail.com');
                    $omMessage->setSubject("Alert! Your subscription plan's expiring tomorrow"); 
                    $omMessage->setBody($content_html, 'text/html', 'utf-8');

                    $result = Yii::app()->mail->send($omMessage);
                }

                if(!empty($next_week_expire_subscriptions))
                {
                    $content_html = $this->renderPartial("/emailTemp/subscription_expire",array('expire_subscriptions' => $next_week_expire_subscriptions,'studio_name' => $studio_name,'expire_day_text'=> 'next week'),true);

                    $omMessage = new YiiMailMessage; 
                    $omMessage->setTo($studio_email);
                    //$omMessage->setTo("jamal.inheritx@gmail.com");
                    $omMessage->setFrom('inx.email001@gmail.com');
                    $omMessage->setSubject("Alert! Your subscription plan's expiring next week"); 
                    $omMessage->setBody($content_html, 'text/html', 'utf-8');

                    $result = Yii::app()->mail->send($omMessage);
                }

                if(!empty($next_month_expire_subscriptions))
                {
                    $content_html = $this->renderPartial("/emailTemp/subscription_expire",array('expire_subscriptions' => $next_month_expire_subscriptions,'studio_name' => $studio_name,'expire_day_text'=> 'next month'),true);

                    $omMessage = new YiiMailMessage; 
                    $omMessage->setTo($studio_email);
                    //$omMessage->setTo("jamal.inheritx@gmail.com");
                    $omMessage->setFrom('inx.email001@gmail.com');
                    $omMessage->setSubject("Alert! Your subscription plan's expiring next month");
                    $omMessage->setBody($content_html, 'text/html', 'utf-8');

                    $result = Yii::app()->mail->send($omMessage);
                }
            }
        }
    }
}

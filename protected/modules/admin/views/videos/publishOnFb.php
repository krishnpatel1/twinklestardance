<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# video: http://ogp.me/ns/video#">
        <title>Publis Video on FB</title>

        <meta property="fb:app_id" content="<?php echo Yii::app()->params['FACEBOOK_APPID']; ?>" />
        <meta property="og:title" content="<?php echo $omVideo->title; ?>" />
        <meta property="og:image" content="<?php echo $omVideo->image_url; ?>" />
        <meta property="og:url" content="<?php echo Yii::app()->createAbsoluteUrl('admin/videos/publishOnFb', array('id' => $omVideo->id)); ?>" />
        <meta property="og:type" content="video.other" />
        <style>
            body {
                font-family: Helvetica, sans-serif;
            }

            #wrapper {
                margin: 0 auto;
                width: 640px;
            }

            h1 {
                font-size: 1.4em;
                text-align: center;
            }

            table {
                width: 100%;
            }

            .key {
                text-align: right;
                width: 200px;
            }

            .key, .value {
                padding: 3px 10px 3px 0;
                word-break: break-word;
            }

            tr:nth-of-type(even) {
                background-color: #DDDDDD;
            }

            tr:nth-of-type(odd) {
                background-color: #EEEEEE;
            }
        </style>
    </head>
    <body>
        <div id="wrapper">
            <h1>OG Sample Object - Sample Video</h1>
            <table border="0" cellspacing="0">
                <tr>
                    <th class="key">fb:app_id</th>
                    <td class="value"><?php echo Yii::app()->params['FACEBOOK_APPID']; ?></td>
                </tr>
                <tr>
                    <th class="key">og:title</th>
                    <td class="value"><?php echo $omVideo->title; ?></td>
                </tr>
                <tr>
                    <th class="key">og:image</th>
                    <td class="value"><?php echo $omVideo->image_url; ?></td>
                </tr>
                <tr>
                    <th class="key">og:url</th>
                    <td class="value"><?php echo Yii::app()->createAbsoluteUrl('admin/videos/publishOnFb', array('id' => $omVideo->id)); ?></td>
                </tr>
                <tr>
                    <th class="key">og:type</th>
                    <td class="value">video.other</td>
                </tr>
            </table>
        </div>
    </body>
</html>

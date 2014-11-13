<?php
/**
 * View for show the index page where the user
 * will be redirect in case that scan the QR
 * Code with a different app that our. This is
 * important because this is the manner to get
 * users to use this platform
 **/
echo link_tag('statics/css/main.css');
?>
<div id="background-body-user" style="margin: auto">
    <div style="padding-left: 520px; padding-top: 40px;">
        <?php echo anchor('https://itunes.apple.com/us/app/qr-fzt/id582703528?l=es&ls=1&mt=8',
                          img(array('src'=>'statics/img/webQR-FZT_apple.png',
                                    'width'=>'150px',
                                    'height'=>'152px',
                                    'style'=>'border: none')),
                          array('style'=>'text-decoration: none', 'target'=>'_blank')); ?>
    </div>
    <div style="padding-left: 135px; padding-top: 210px;">
        <?php echo anchor('#',
                          img(array('src'=>'statics/img/webQR-FZT_android.png',
                                    'width'=>'152px',
                                    'height'=>'148px',
                                    'style'=>'border: none')),
                          array('style'=>'text-decoration: none', 'target'=>'_blank')); ?>
    </div>
</div>

<?php
/**
 * Master template where the system will
 * make all the process of load the internal
 * views in this part
 **/
?>
<!Doctype html>
<html lang="es">
    <head>
        <?php echo link_tag('statics/css/main.css'); ?>
        <?php echo link_tag('statics/css/text.css'); ?>
        <meta charset="utf-8" />
        <script type="text/javascript" src="<?php echo base_url().'statics/js/jquery.js'; ?>"></script>
        <?php if(isset($included_js)): ?>
            <?php foreach($included_js as $js): ?>
                <script type="text/javascript" src="<?php echo base_url().$js; ?>"></script>
            <?php endforeach; ?>
        <?php endif; ?>
    </head>
    <body>
        <header>
            <?php if(isset($header)): ?>
                <?php echo $header; ?>
            <?php endif; ?>
        </header>
        <section>
            <?php echo $content; ?>
        </section>
    </body>
</html>
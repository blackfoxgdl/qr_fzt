<?php
/**
 * View where load the form where the client
 * could login and can insert the messages
 * and create campains
 **/
?>
<script type="text/javascript" src="<?php echo base_url().'statics/js/jquery.js'; ?>"></script>
<script type="text/javascript" src="<?php echo base_url().'statics/js/index.js'; ?>"></script>
<div id="centrar">
    <div class="center_web">
        <div id="backgrounds-clients">
            <div style="padding-top: 145px; padding-left: 270px">
                <?php echo anchor('clients/check_email_pass', '', array('id'=>'url_base', 'style'=>'display: none')); ?>
                <?php echo form_open('clients/login', array('id'=>'', 'onsubmit'=>'return check_data();')); ?>
                    <div id="main_error" class="font-type" style="display: none; color: #FF0000">
                        El Email o Password son incorrectos.
                    </div>
                    <div style="padding-bottom: 5px; text-align: right; padding-right: 4px">
                        <span class="font-type">
                            <?php echo form_label('Email: ', 'emailLogin'); ?>
                        </span>
                        <span>
                            <?php echo form_input(array('id'=>'emailCliente',
                                                        'class'=>'',
                                                        'name'=>'Login[clientEmail]',
                                                        'style'=>'width: 165px',
                                                        'value'=>'')); ?>
                        </span>
                        <div id="error1" class="font-type" style="display: none; color: #FF0000">
                            Por favor, escribe un correo valido.
                        </div>
                        <div id="error2" class="font-type" style="display: none; color: #FF0000">
                            Por favor, escribe tu correo.
                        </div>
                    </div>
                    <div style="padding-bottom: 3px">
                        <span style="text-align: right" class="font-type">
                            <?php echo form_label('Password: ', 'passwordLogin'); ?>
                        </span>
                        <span>
                            <?php echo form_password(array('id'=>'passwordCliente',
                                                           'class'=>'',
                                                           'name'=>'Login[clientPassword]',
                                                           'style'=>'width: 165px',
                                                           'value'=>'')); ?>
                        </span>
                        <div id="error" class="font-type" style="display: none; color: #FF0000">
                            Por favor, ingrese su password.
                        </div>
                    </div>
                    <div style="text-align: right; margin-right: 5px;">
                        <?php echo form_submit(array('id'=>'botton_login',
                                                     'class'=>'',
                                                     'name'=>'',
                                                     'value'=>'')); ?>
                    </div>
                <?php echo form_close();?>
            </div>
            <div style="padding-left: 295px; padding-top: 50px">
                <?php echo img(array('src'=>'statics/img/tan_sencillo.png',
                                     'width'=>'218px',
                                     'height'=>'52px')); ?>
            </div>
        </div>
    </div>
</div>
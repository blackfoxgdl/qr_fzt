<?php
/**
 * View for check all the data of the clients
 * or they can create a new campain for can create
 * the messages and the QR Code
 **/
?>
    <script type="text/javascript" src="<?php echo base_url().'statics/js/campain.js'; ?>"></script>
    <?php echo form_open_multipart('clients/save_campaign', array('id'=>'form_new_campain')); ?>
        <div class="font-type" style="padding-top: 10px">
            <div style="color: #FF0000; display: none; padding-left: 100px" class="font-type" id="name_campain">
                Escribe el nombre de la campa&ntilde;a.
            </div>
            <span>
                <?php echo form_label('Nombre de la campa&ntilde;a: ', 'nameCampain'); ?>
            </span>
            <span>
                <?php echo form_input(array('id'=>'campain_name',
                                            'class'=>'',
                                            'name'=>'Campain[campainName]',
                                            'value'=>'',
                                            'style'=>'width: 375px')); ?>
            </span>
        </div>
        <div style="padding-top: 10px;">
            <div style="color: #FF0000; display: none; padding-left: 100px" class="font-type" id="fb_message">
                Escribe Un mensaje para FB.
            </div>
            <span style="float: left; padding-left: 100px" class="font-type">
                <?php echo form_label('Mensaje:', 'mensajeFB'); ?>
            </span>
            <span>
                <?php echo form_textarea(array('id'=>'message_fb',
                                               'class'=>'',
                                               'name'=>'Message[messageFacebook]',
                                               'value'=>'',
                                               'style'=>'width: 379px; height: 100px; margin-left: 4px;')); ?>
            </span>
        </div>
        <div style="padding-top: 10px">
            <div style="color: #FF0000; display: none;padding-left: 100px;" class="font-type" id="subject_message">
                Ingresa el asunto del correo.
            </div>
            <span style="margin-left: 47px;" class="font-type">
                <?php echo form_label('Asunto del Email:', 'asuntoEmail'); ?>
            </span>
            <span>
                <?php echo form_input(array('id'=>'subject_email',
                                            'class'=>'',
                                            'name'=>'Message[messageSubject]',
                                            'value'=>'',
                                            'style'=>'width: 375px;')); ?>
            </span>
        </div>
        <div style="padding-top: 10px">
            <div style="color: #FF0000; display: none; padding-left: 100px" class="font-type" id="email_message">
                Ingresa un mensaje de correo.
            </div>
            <span style="float: left; margin-left: 60px" class="font-type">
                <?php echo form_label('Mensaje Email:', 'mensajeMail'); ?>
            </span>
            <span>
                <?php echo form_textarea(array('id'=>'message_email',
                                               'class'=>'',
                                               'name'=>'Message[messageMail]',
                                               'value'=>'',
                                               'style'=>'width: 379px; height: 100px; margin-left: 4px;')); ?>
            </span>
        </div>
        <div style="padding-top: 10px">
            <div style="color: #FF0000; display: none; padding-left: 100px" class="font-type" id="dropdown_option">
                Selecciona una opcion.
            </div>
            <span class="font-type" style="padding-left: 40px">
                <?php echo form_label('Seleccion Accion: ', 'seleccionAccion'); ?>
            </span>
            <span style="margin-left: 4px">
                <?php if($this->session->userdata('id') != 4 || $this->session->userdata('id') != '4'): ?>
                    <?php $array = array('0' => 'Selecciona una accion',
                                         '1' => 'Posteo en Facebook',
                                         '2' => 'Envio de Correo',
                                         '3' => 'Envio de correo y posteo de Facebook',
                                         '4' => 'Compartir un video por Facebook'/*,
                                         '5' => 'Subir un video',
                                         '6' => 'Envio de Correo y postear imagen en facebook'*/); ?>
                <?php else: ?>
                    <?php $array = array('0' => 'Selecciona una accion',
                                         '1' => 'Posteo en Facebook',
                                         '2' => 'Envio de Correo',
                                         '3' => 'Envio de correo y posteo de Facebook',
                                         '4' => 'Compartir un video por Facebook',
                                         '5' => 'Campa–a en Bares',/*
                                         '6' => 'Envio de Correo y postear imagen en facebook'*/); ?>
                <?php endif; ?>
                <?php $options_drop = 'id="dropdown_select"
                                       class="selects"'; ?>
                <?php echo form_dropdown('Campain[campainType]', $array, '', $options_drop); ?>
            </span>
        </div>
        <div style="padding-top: 10px; display: none" id="imagen_select">
            <div style="display: none; color: #FF0000; padding-left: 100px" class="font-type" id="upload_image">
                Selecciona una imagen
            </div>
            <span class="font-type" style="padding-left: 37px">
                <?php echo form_label('Sube una imagen: ', 'uploadImagen'); ?>
            </span> 
            <span style="margin-left: 4px">
                <?php echo form_upload(array('id'=>'image_upload',
                                             'class'=>'',
                                             'name'=>'imagen',
                                             'value'=>'',
                                             'flag'=>'0')); ?>
            </span> 
        </div>
        <div style="padding-top: 10px; display: none" id="video_select">
            <div>
                <div class="font-type" style="padding-left: 100px; display: none; color: #FF0000;" id="select_video">
                    Ingresa o selecciona la direccion del video.
                </div>
                <span class="font-type" style="padding-left: 71px">
                    <?php echo form_label('Url del video: ', 'oUrlUpload'); ?>
                </span>
                <span style="margin-left: 4px">
                    <?php echo form_input(array('id'=>'',
                                                'class'=>'video_selected',
                                                'name'=>'videoYT',
                                                'value'=>'',
                                                'style'=>'width: 375px',
                                                'flag'=>'0')); ?>
                </span>
            </div>
        </div>
        <div style="padding-top: 10px">
            <span style="padding-left: 445px;">
                <?php echo form_submit(array('id'=>'botton_campana',
                                             'class'=>'',
                                             'name'=>'',
                                             'value'=>'')); ?>
                <?php echo anchor('clients/qr_code', '', array('style'=>'display: none', 'id'=>'final_url')); ?>
                <?php echo anchor('',
                                  img(array('src'=>'statics/img/boton_crear_qr.png',
                                            'width'=>'99px',
                                            'height'=>'32px',
                                            'style'=>'border: none; text-decoration: none')),
                                  array('style'=>'display: none', 'class'=>'', 'id'=>'botone_create_qr')); ?>
            </span>
        </div>
    <?php echo form_close(); ?>
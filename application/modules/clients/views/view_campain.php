<?php
/**
 * View where the sign in user can view all
 * the message or information used for know
 * what is the campain created by the company
 **/
?>
<script type="text/javascript" src="<?php echo base_url().'statics/js/jquery.js'; ?>"></script>
<script type="text/javascript" src="<?php echo base_url().'statics/js/view_campain.js'; ?>"></script>
<div style="margin-left: 0px">
    <?php foreach($all as $single): ?>
        <div>
            <div class="sencilla_campana" id="campain<?php echo $single->campainId; ?>">
                <div class="font-type">
                    <span>
                        Nombre Campa&ntilde;a: 
                    </span>
                    <span id="name<?php echo $single->campainId; ?>">
                        <?php echo $single->campainName; ?>
                    </span>
                </div>
                <div class="font-type">
                    <span style="padding-left: 65px">
                        Mensaje:
                    </span>
                    <span id="mensaje<?php echo $single->campainId; ?>">
                        <?php echo $single->messageFacebook; ?>
                    </span>
                </div>
                <div class="font-type">
                    <span style="padding-left: 75px">
                        Correo:
                    </span>
                    <span id="correo<?php echo $single->campainId; ?>">
                        <?php echo $single->messageMail; ?>
                    </span>
                </div>
                <div class="font-type">
                    <span style="padding-left: 7px">
                        Tipo de Campa&ntilde;a:
                    </span>
                    <span>
                        <?php echo type_campain($single->campainType); ?>
                    </span>
                </div>
                <div>
                    <span style="float: right">
                        <?php echo anchor('#',
                                          img(array('src'=>'statics/img/boton_editar.png',
                                                    'width'=>'100px',
                                                    'height'=>'29px')),
                                          array('id'=>$single->campainId, 'class'=>'update_data')); ?>
                    </span>
                </div>
            </div>
            <div style="clear: both"></div>
            <div id="form<?php echo $single->campainId; ?>" style="display: none">
                <?php echo form_open('clients/update_campain/'.$single->campainId.'/'.$single->messagesId, array('id'=>'form_'.$single->campainId, 'class'=>'forms')); ?>
                    <div style="padding-top: 10px">
                        <span class="font-type">
                            <?php echo form_label("Nombre de la Campa&ntilde;a: ", "nombreCampain"); ?>
                        </span>
                        <span>
                            <input type="hidden" name="id_company_campain" value="<?php echo $single->campainCompanyId; ?>" />
                            <?php echo form_input(array('id'=>'text_campain_name'.$single->campainId,
                                                        'class'=>'',
                                                        'name'=>'CampainEdit[campainName]',
                                                        'value'=>$single->campainName,
                                                        'style'=>'width: 360px')); ?>
                        </span>
                    </div>
                    <div style="padding-top: 10px">
                        <span class="font-type" style="float: left; padding-left: 103px">
                            <?php echo form_label("Mensaje: ", "mensajeFacebook"); ?>
                        </span>
                        <span>
                            <?php echo form_textarea(array('id'=>'text_mensaje_facebook'.$single->campainId,
                                                           'class'=>'',
                                                           'name'=>'MessageEdit[messageFacebook]',
                                                           'value'=>$single->messageFacebook,
                                                           'style'=>'',
                                                           'style'=>'width: 364px; height: 100px; margin-left: 4px;')); ?>
                        </span>
                    </div>
                    <div style="padding-top: 10px">
                        <span class="font-type" style="float: left; padding-left: 33px">
                            <?php echo form_label("Mensaje de correo: ", "mensajeCorreo"); ?>
                        </span>
                        <span>
                            <?php echo form_textarea(array('id'=>'text_mensaje_correo'.$single->campainId,
                                                           'class'=>'',
                                                           'name'=>'MessageEdit[messageMail]',
                                                           'value'=>$single->messageMail,
                                                           'style'=>'width: 364px; height: 100px; margin-left: 4px;')); ?>
                        </span>
                    </div>
                    <div style="padding-top: 10px">
                        <span class="font-type" style="padding-left: 38px">
                            <?php echo form_label('Selecciona Acci&oacute;n: ', 'seleccionaAccion'); ?>
                        </span>
                        <span>
                            <?php $clases = 'id="dropdown_select"'; ?>
                            <?php if($single->campainId != 4 || $single->campainId != '4'): ?>
                                <?php $array = array('0' => 'Selecciona una accion',
                                         '1' => 'Posteo en Facebook',
                                         '2' => 'Envio de Correo',
                                         '3' => 'Envio de correo y posteo de Facebook',
                                         '4' => 'Compartir un video por Facebook'); ?>
                            <?php else: ?>
                                <?php $array = array('0' => 'Selecciona una accion',
                                         '1' => 'Posteo en Facebook',
                                         '2' => 'Envio de Correo',
                                         '3' => 'Envio de correo y posteo de Facebook',
                                         '4' => 'Compartir un video por Facebook',
                                         '5' => 'Campa–a en Bares'); ?>
                            <?php endif; ?>
                            <?php echo form_dropdown('CampainEdit[campainType]', $array, $single->campainType, $clases); ?>
                        </span>
                    </div>
                    <div style="padding-top: 10px" id="video_field">
                        <?php if($single->campainType == 4): ?>
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
                        <?php endif; ?>
                    </div>
                    <div style="float: right">
                        <?php echo anchor('clients/qr_code/'.$single->campainId,
                                  img(array('src'=>'statics/img/boton_crear_qr.png',
                                            'width'=>'99px',
                                            'height'=>'32px',
                                            'style'=>'border: none; text-decoration: none; float: left')),
                                  array('class'=>'', 'id'=>'botone_create_qr')); ?>
                        <?php echo form_submit(array('id'=>'',
                                                     'class'=>'boton_guardar_editar',
                                                     'name'=>'',
                                                     'value'=>'')); ?>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
        <div style="clear: both"></div>
        <div style="text-align: center">
            <?php echo img(array('src'=>'statics/img/separador.png',
                                 'width'=>'417px',
                                 'height'=>'9px')); ?>
        </div>
    <?php endforeach; ?>
</div>
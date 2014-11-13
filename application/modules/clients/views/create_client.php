<?php
/**
 * View where can create the companies or create
 * the clients. With this form can give them the
 * posibility of create their own campains and can
 * type the message for twitter, facebook and a message
 * to want to receive the user by email.
 **/
?>
<div>
    <?php echo form_open('clients/save_client'); ?>
        <div>
            <span>
                <?php echo form_label('Nombre: ', 'nombreCliente'); ?>
            </span>
            <span>
                <?php echo form_input(array('id'=>'',
                                            'class'=>'',
                                            'name'=>'Cliente[clientName]',
                                            'value'=>'')); ?>
            </span>
        </div>
        <div>
            <span>
                <?php echo form_label('Direccion: ', 'direccionCliente'); ?>
            </span>
            <span>
                <?php echo form_input(array('id'=>'',
                                            'class'=>'',
                                            'name'=>'Cliente[clientAddress]',
                                            'value'=>'')); ?>
            </span>
        </div>
        <div>
            <span>
                <?php echo form_label('Email: ', 'emailCliente'); ?>
            </span>
            <span>
                <?php echo form_input(array('id'=>'',
                                            'class'=>'',
                                            'name'=>'Cliente[clientEmail]',
                                            'value'=>'')); ?>
            </span>
        </div>
        <div>
            <span>
                <?php echo form_label('Password: ', 'passwordClient'); ?>
            </span>
            <span>
                <?php echo form_password(array('id'=>'',
                                               'class'=>'',
                                               'name'=>'Cliente[clientPassword]',
                                               'value'=>'')); ?>
            </span>
        </div>
        <div>
            <?php echo form_submit(array('id'=>'',
                                         'class'=>'',
                                         'name'=>'',
                                         'value'=>'Guardar')); ?>
        </div>
    <?php echo form_close(); ?>
</div>
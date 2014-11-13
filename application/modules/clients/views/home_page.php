<?php
/**
 * View where the user can watch all the
 * posible options that can select for
 * create the QR Code like final product
 **/
?>
<div id="centrar">
    <div class="center_web">
        <div id="backgrounds-clients">
            <div style="width: 500px">
                <div style="float: left; padding-left: 325px; padding-top: 85px">
                    Hola, <?php echo $specific_data->clientName; ?>
                </div>
            </div>
            <div style="clear: both"></div>
            <div style="padding-left: 85px; width: 500px">
                <div style="float: left">
                    <?php echo anchor('clients/campaigns',
                                      img(array('src'=>'statics/img/boton_crear_campana.png',
                                                'width'=>'154px',
                                                'height'=>'40px',
                                                'id'=>'imgCreateCampain')),
                                      array('id'=>'create_campain', 'class'=>'')); ?>
                </div>
                <div style="float: left">
                    <?php echo anchor('clients/view_all_campaigns/'.$this->session->userdata('id'),
                                      img(array('src'=>'statics/img/boton_ver_campana.png',
                                                'width'=>'155px',
                                                'height'=>'40px',
                                                'id'=>'imgViewEditCampain')),
                                      array('id'=>'watch_campain', 'class'=>'')); ?>
                </div>
                <div style="float: left">
                    <?php echo //anchor('#',
                                      img(array('src'=>'statics/img/boton_ver_cuenta.png',
                                                'width'=>'154px',
                                                'height'=>'40px'));//,
                                 //     array('id'=>'', 'class'=>'')); ?>
                </div>
            </div>
            <div style="clear: both"></div>
            <div id="container_information" style="width: 545px">
            </div>
        </div>
    </div>
</div>
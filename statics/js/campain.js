/**
 * File for make all the validations and process
 * of make the load of views dinamically in div
 * but the system doesn't load the completly page
 **/

$(document).ready(function(){
        
    //LOAD THE EVENT OR BUTTON FOR MAKE THE
    //PROCESS OF REMARK THE BUTTON OF SECTION
    //WHERE THE USER STAND
    //$("#imgCreateCampain").attr('src', 'statics/img/boton_activo_campana.png');
    
    //EVENT FOR LOAD THE FORM IN THE PART OF
    //THE BOTTOM PAGE
    $("#create_campain").click(function(event){
        event.preventDefault();
        //$("#imgCreateCampain").attr('src', '/../statics/img/boton_activo_campana.png');
        //$("#imgViewEditCampain").attr('src', '/../statics/img/boton_ver_campana.png');
        $("#imgCreateCampain").attr('src', '/qr_fzt/statics/img/boton_activo_campana.png');
        $("#imgViewEditCampain").attr('src', '/qr_fzt/statics/img/boton_ver_campana.png');
        url = $(this).attr('href');
        $("#container_information").load(url);
    });
    
    //load the library form
    //$.getScript('/statics/js/form.js');
    $.getScript('/qr_fzt/statics/js/form.js');
    
    /**
     * Event that will be execute once the user click the button
     * of the save data for create the campain where can load the
     * ajax for make the process of submit data
     **/
    $("#form_new_campain").submit(function(){
        
        var band = 0;
        
        if($("#campain_name").val() == '')
        {
            $("#name_campain").show();
            band++;
        }
        else{
            $("#name_campain").hide();
        }
        
        if($("#message_fb").val() == '')
        {
            $("#fb_message").show();
            band++;
        }
        else{
            $("#fb_message").hide();
        }
        
        if($("#subject_email").val() == '')
        {
            $("#subject_email").show();
            band++;
        }
        else {
            $("#subject_email").hide();
        }
        
        if($("#message_email").val() == '')
        {
            $("#email_message").show();
            band++;
        }
        else{
            $("#email_message").hide();
        }
        
        if($("#dropdown_select").val() == '0' || $("#dropdown_select").val() == 0)
        {
            $("#dropdown_option").show();
            band++;
        }
        else{
            $("#dropdown_option").hide();
        }
        
        if($("#image_upload").val() == '' && $("#image_upload").attr('flag') == 1)
        {
            $("#upload_image").show();
            band++;
        }
        else{
            $("#upload_image").hide();
        }
        
        if($(".video_selected").val() == '' && $('.video_selected').attr('flag') == 1)
        {
            $("#select_video").show();
            band++;
        }
        else{
            $("#select_video").hide();
        }
        
        if(band != 0)
        {
            return false;
        }
        else{   
            var options = {
                success: successful
            }
            $(this).ajaxSubmit(options);
            return false;
        }
    });
    
    /**
     * Event used for show or hide the information where
     * the user can select upload the image or video, depending
     * what need to do
     **/
    $("#dropdown_select").change(function(event){
        event.preventDefault();
        type = $(this).val();
        if(type == 5)
        {
            $("#video_select").hide();
            $("#imagen_select").show();
            $("#image_upload").attr('flag', '1');
            $(".video_selected").attr('flag', '0');
        }
        else if(type == 4)
        {
            $("#imagen_select").hide();
            $("#video_select").show();
            $("#image_upload").attr('flag', '0');
            $(".video_selected").attr('flag', '1');
        }
        else
        {
            $("#imagen_select").hide();
            $("#video_select").hide();
            $("#image_upload").attr('flag', '0');
            $(".video_selected").attr('flag', '0');
        }
    });
});
    
/**
 * Function where load then execute the form once click in the part of
 * the create the campain with the information to share and make in the
 * part of the qr code
 **/
function successful(responseText)
{
    $("#botton_campana").hide();
    $("#botone_create_qr").show();
    url = $('#final_url').attr('href');
    //url with the id of campain
    final_url = url + "/" + responseText;
    $("#botone_create_qr").attr("href", final_url);
}
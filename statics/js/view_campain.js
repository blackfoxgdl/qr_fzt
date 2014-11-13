//FILE WHERE MAKE ALL THE PROCESS OF THE
//PART FOR THE CLIENT CAN WATCH HOW LOAD
//THE FORMS IN THE BOTTOM OF THE PAGE OR SITE

$(document).ready(function(){
    
    var flag;
    
    //load the library form
    //$.getScript('/statics/js/form.js');
    $.getScript('/qr_fzt/statics/js/form.js');
    
    //EVENT FOR LOAD ALL THE FORM BUT WITH THE
    //DATA LOADED INTHE SAME PAGE BUT THIS MANNER IS
    //MANIPULATE DINAMYCALLY
    
    /**
     * Event that make the process to display inline the form
     * for edit the data and hide the data like text plain. Inside
     * this event will make the process of the submit form.
     **/
    $(".update_data").click(function(event){
        event.preventDefault();
        flag = $(this).attr('id');
        $("#campain"+flag).hide();
        $("#form"+flag).show();
    });
    
    /**
     * Event for make the process of save all the data where the user can check
     * then if the data will update by the system and can update the qr code and the
     * user ain't need to create another qr code
     **/
    $(".forms").submit(function(){
        var options = {
            success: successful
        }
        $(this).ajaxSubmit(options);
        return false;
    });
    
    /**
     *
     **/
   $("#watch_campain").click(function(event){
        event.preventDefault();
        //$("#imgViewEditCampain").attr('src', '/../statics/img/boton_activo_ver.png');
        //$("#imgCreateCampain").attr('src', '/../statics/img/boton_crear_campana.png');
        $("#imgViewEditCampain").attr('src', '/qr_fzt/statics/img/boton_activo_ver.png');
        $("#imgCreateCampain").attr('src', '/qr_fzt/statics/img/boton_crear_campana.png');
        url = $(this).attr('href');
        $("#container_information").load(url);
    });
   
   /**
    *
    **/
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
            $("#video_field").hide();
            $("#video_select").hide();
            $("#imagen_select").show();
            $("#image_upload").attr('flag', '1');
            $(".video_selected").attr('flag', '0');
        }
        else if(type == 4)
        {
            $("#video_field").show();
            $("#imagen_select").hide();
            $("#video_select").show();
            $("#image_upload").attr('flag', '0');
            $(".video_selected").attr('flag', '1');
        }
        else
        {
            $("#video_field").hide();
            $("#imagen_select").hide();
            $("#video_select").hide();
            $("#image_upload").attr('flag', '0');
            $(".video_selected").attr('flag', '0');
        }
    });
});

/**
 * Function that makes all the process to hide the form and
 * show the text pain with the data updated, all this for the
 * user watch that the data did updated
 **/
function successful(responseText)
{
    $("#name"+responseText).text($("#text_campain_name"+responseText).val());
    $("#mensaje"+responseText).text($("#text_mensaje_facebook"+responseText).val());
    $("#correo"+responseText).text($("#text_mensaje_correo"+responseText).val());
    $("#form"+responseText).hide();
    $("#campain"+responseText).show();
}
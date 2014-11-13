//FILE USED FOR CHECK ALL THE VALUES OF THE
//PART IN THE LOGIN SCREEN. THIS IS IMPORTANT BECUASE
//VALIDATE ALL THE VALUES NEEDED IN THIS PART

/**
 * Function that check all the values for know if
 * the user has typed some data or not, and the system
 * knows if the data are valid as well.
 **/
function check_data()
{
    band = 0;
    
    //CREATE THE VALIDATIONS
    if($("#emailCliente").val() == '')
    {
        $("#error1").hide();
        $("#error2").show();
        band++;
    }
    else{
        if(/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test($("#emailCliente").val()))
        {
           $("#error1").hide();
           $("#error2").hide();
        }
        else{
           $("#error1").show();
           $("#error2").hide();
           band++;
        }
    }
    
    if($("#passwordCliente").val() == '')
    {
        $("#error").show();
        band++;
    }
    else{
        $("#error").hide();
    }
    
    if(band == 0)
    {
        url = $("#url_base").attr('href');
        value = $.ajax({
                            type: "POST",
                            url: url,//+'/'+$("#emailCliente").val()+'/'+$("#passwordCliente").val(),
                            data: {email: $("#emailCliente").val(), pass: $("#passwordCliente").val()},
                            async: false
                       }).responseText;
        if(value == 0)
        {
            $("#error1").hide();
            $("#error2").hide();
            $("#error").hide();
            $("#main_error").show();
            band++;
        }
        else{
            $("#error1").hide();
            $("#error2").hide();
            $("#error").hide();
            $("#main_error").hide();
        }
    }
    
    //CHECK THE BAND VAR AND THE SYSTEM KNOW
    //WHAT DO IT DO
    if(band != 0)
    {
        return false;
    }
    else{
        return true;
    }
}
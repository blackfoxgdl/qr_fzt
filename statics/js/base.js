//FILE FOR GET ALL THE VALUES OF
//THE BASE URL FOR TAKE THE URL DINAMICALLY
//ONCE THE USER SELECT ONE OPTION. WITH THAT
//THE SYSTEM REMARK THE SECTION WHERE THE USER
//WILL BE BROWSE

/**
 *
 **/
function getBaseUrl()
{
    var url = location.href;
    var base = url.substring(0, url.indexOf('/', 15));
    if(base.indexOf('http://codigosqr') != -1)
    {
        //URL BASE FOR LOCALHOST
        var url = location.href;
        var pathname = location.pathname;
        var url1 = url.indexOf(pathname);
        var url2 = url.indexOf("/", url1 + 1);
        var localBase = url.substring(0, url2);
        return localBase;// + "/index.php";
    }
    else{
        return base + "/index.php";
        //return base + "/auctions/index.php";
        
    }
}

/**
 *
 **/

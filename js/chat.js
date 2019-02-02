var jQueryScriptOutputted = false;
function initJQuery() {
    if (typeof (jQuery) == 'undefined') {


        if (!jQueryScriptOutputted) {
            jQueryScriptOutputted = true;

            document.write("<scr" + "ipt type=\"text/javascript\" src=\"//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js\"></scr" + "ipt>");
        }
        setTimeout("initJQuery()", 50);
    } else {

        jQuery(document).ready(function ($) {

        $('<a>',
            { id: 'cy_link',
                click: function () {
                    if (cy_t == "1") {
                        window.open("https://www.canliyardim.co/client/c.aspx?mid=" + cy_mid + "&code=" + cy_code, "CanliYardim", "menubar=1,resizable=1,width=330,height=480");
                    }
                    else {

                        $('<div>', { id: 'cy_bg' }).appendTo('body')
                        .css({ 'position': 'fixed', 'left': '0', 'width': '100%', 'height': '100%', 'top': '0',
                           'display': 'none'
                        });

                        $('<a>',
                        { id: 'cy_kapat',
                            click: function () {
                                $("#cy_kapat").hide();
                                $("#cy_bg").hide();
                                $("#cy_ifrm").hide("slow");
                                setTimeout(function () { $("#cy_link").show().css({ opacity: 0 }).animate({ opacity: 1 }, 1000) }, 500);
                            }
                        }).appendTo('body').css({ 'position': 'fixed', 'left': '50%', 'width': '25px', 'height': '29px', 'top': '30px', 'cursor': 'pointer',
                            'margin-left': '143px', 'z-index': '999998', 'display': 'none', 'background': 'url(https://www.canliyardim.co/images/x.png) no-repeat'
                        });

                        $("#cy_link").hide();
                        $("#cy_bg").show();
                        $("#cy_kapat").show();
                        $("#cy_ifrm").css({ opacity: 1 }).show("slow");
                    }
                }
            }).appendTo('body').css({ 'position': 'fixed', 'cursor': 'pointer', 'margin': '0', 'padding': '0',
                'background': 'url(https://www.canliyardim.co/images/button' + cy_r + '.png) no-repeat', 'z-index': '999999'
            });



        if (cy_k == "2")
            $("#cy_link").css({ 'background-position': '-36px 0', 'top': cy_p + '%', 'right': '0px', 'width': '36px', 'height': '104px' });

        else if (cy_k == "3")
            $("#cy_link").css({ 'background-position': '-72px -36px', 'left': cy_p + '%', 'bottom': '0px', 'width': '104px', 'height': '36px' });

        else if (cy_k == "4")
            $("#cy_link").css({ 'background-position': '-72px 0px', 'left': cy_p + '%', 'top': '0px', 'width': '104px', 'height': '36px' });

        else /*if (k == "1")*/
            $("#cy_link").css({ 'background-position': '0 0', 'top': cy_p + '%', 'left': '0px', 'width': '36px', 'height': '104px' });

        $("#cy_link").hide();
        setTimeout(function () { $("#cy_link").show().css({ opacity: 0 }).animate({ opacity: 1 }, 1000); }, 500);


        $('<iframe />', { id: 'cy_ifrm', frameborder: '0', marginheight: '0', marginwidth: '0',
            src: 'https://www.canliyardim.co/client/c.aspx?mid=' + cy_mid + '&code=' + cy_code
        }).appendTo('body').css({ 'position': 'fixed', 'left': '50%', 'width': '330px', 'height': '470px', 'top': '40px',
            'margin-left': '-160px', 'z-index': '999997', 'display': 'none'
        });
    });
    }

}

initJQuery();
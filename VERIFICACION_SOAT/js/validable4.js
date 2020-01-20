/* for NEW SIMPLE tested with jQuery v1.10.2
 *
 * usage:
    loadValidable({
        reqInput: 'req',
        reqSelect: 'req',
        callback: 'verifyDate'
    });
 *
 *  * utf8 support
 * onfocus highlight was deleted
 * alpha and currency types were deleted
 * event click automatically add to class a.button
 * customized for input with inpB and req classes
 * inpB DELETED bug on focus submit
 * versoin 4 parametrizable
 * loading class show hide
 *
 * ****** BUG CLEAR PREVIUS REQS *******
 * div_3 added for extra messages
 * unbind added
 * TYPE textarea added
 *
 */
var filters = {
    required: function(el) {
        return ($(el).val() !== '' && $(el).val() !== -1);
    },
    email: function(el) {
        return /^[A-Za-z][A-Za-z0-9_\.\-]*@[A-Za-z0-9_\-]+\.[A-Za-z0-9_.\-]+[A-za-z]$/.test($(el).val());
    },
    numeric: function(el) {
        return /^[0-9]*\.?[0-9]*$/.test($(el).val());
    },
    phone: function(el) {
        return /^[0-9\-()]*$/.test($(el).val());
    },
    currency: function(el) {
        return /^[0-9]*\.?[0-9]{0,2}$/.test($(el).val());
    },
    alpha: function(el) {
        return /^[a-zA-Z áéíóúAÉÍÓÚÑñ\.,;:\|)"(º_@><#&\'\?¿¡!/\\%\$=]*$/.test($(el).val());
    },
    alphanum: function(el) {
        return /^[a-zA-Z0-9 áéíóúAÉÍÓÚÑñëïüÿâêîôûàèìòùæç\-\.,;:\|)"(º_@><#&\'\?¿¡!/\\%\$=]*$/.test($(el).val());
    },
    textarea: function(el) {
        return /^[a-zA-Z0-9 áéíóúAÉÍÓÚÑñëïüÿâêîôûàèìòùæç\-\.,;:\|)"(º_@><#&\'\?¿¡!/\\%\$=(^|\r\n|\n)]*$/.test($(el).val());
    },
    password: function(el) {
        return /^[a-zA-Z0-9áéíóúAÉÍÓÚÑñëïüÿç\.,;:\|)"(º_@><#&\'\?¿¡!/\\%\$=\*\+]*$/.test($(el).val());
    }
};

$.extend({
    /* PARAMOS LA EJECUCIÓN*/
    stop: function(e) {
        if (e.preventDefault)
            e.preventDefault();
        if (e.stopPropagation)
            e.stopPropagation();
    }
});


function dumbCallBack(e) {
    return true;

}
;

function loadValidable(args) {
    options = jQuery.extend({
        reqInput: 'reqError',
        reqSelect: 'reqError2',
        reqTextarea: 'reqError3',
        loadClass:'load',
        callback: 'dumbCallBack'
    }, args);

    $("form.validable").unbind("submit");
    //on submit
    $("form.validable").bind("submit", function(e) {

        if (typeof filters === 'undefined')
            return;


        $(this).find("input, textarea, select").each(function(x, el) {


            if ($(el).attr("class") !== 'undefined' && $(el).attr("class") !== '') {

                // clear previus reqs
                aux = el.tagName;
                switch (aux.toUpperCase()) {
                    case 'INPUT'    :
                        $(el).removeClass(options.reqInput);
                        break;
                    case 'SELECT'   :
                        $(el).removeClass(options.reqSelect);
                        break;
                    case 'TEXTAREA' :
                        $(el).removeClass(options.reqTextarea);
                        break;

                }

                $.each(new String($(el).attr("class")).split(" "), function(x, klass) {
                    if ($.isFunction(filters[klass])) {
                        if (!filters[klass](el)) {
                            aux = el.tagName;

                            switch (aux.toUpperCase()) {
                                case 'INPUT'    :
                                    $(el).addClass(options.reqInput);
                                    break;
                                case 'SELECT'   :
                                    $(el).addClass(options.reqSelect);
                                    break;
                                case 'TEXTAREA' :
                                    $(el).addClass(options.reqTextarea);
                                    break;

                            }

                            var idName = $(el).attr("id");
                            if ($(el).val() === '') {
                                $("#div_" + idName).show();
                                $(".boxError").fadeIn(1000);
                            }
                            else {
                                $("#div_" + idName + "_2").show();
                            }
                        }
                    }

                });
            }
        });
        var findClasses = "." + options.reqInput + ", ." + options.reqSelect + ", ." + options.reqTextarea;
        /*var findClasses= ".req, .req2, .req3"; */
        if ($(this).find(findClasses).size() > 0) {
            $.stop(e || window.event);
            return false;
        } else {

            var fnstring = options.callback;
            var fn = window[fnstring];
            if (typeof fn === "function" && fnstring!='dumbCallBack') {
                fn(e);
            } else {
                $('.'+ options.loadClass).show();
                return true;
            }


            /*            var domain = $('#domain').html();
             $('form.validable').find('input.button').after('<span class="loadB"></span>');
             return true;*/
        }
    });

// on focus	remueve los tag de error
    $("form.validable").find("input, textarea, select").each(function(x, el) {
        $(el).bind("focus", function() {
            if ($(el).attr("class") !== 'undefined' && $(el).attr("class") !== '') {

                aux = el.tagName;
                switch (aux.toUpperCase()) {
                    case 'INPUT'    :
                        $(el).removeClass(options.reqInput);
                        break;
                    case 'SELECT'   :
                        $(el).removeClass(options.reqSelect);
                        break;
                    case 'TEXTAREA' :
                        $(el).removeClass(options.reqTextarea);
                        break;

                }

                var idName = $(el).attr("id");
                $("#div_" + idName).hide();
                $(".boxError").fadeOut(1500);
                $("#div_" + idName + "_2").hide();
                $("#div_" + idName + "_3").hide();
            }
        });
    });

// on blur
    $("form.validable").find("input, textarea, select").each(function(x, el) {
        $(el).bind("blur", function() {
            if ($(el).attr("class") !== 'undefined' && $(el).attr("class") !== '') {


                var idName = $(el).attr("id");
                $("#div_" + idName).hide();
                $("#div_" + idName + "_2").hide();
                $("#div_" + idName + "_3").hide();
            }
        });
    });


}
;

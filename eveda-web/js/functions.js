// Mobile sidebar menu
$(".open-mobile-nav").click(function() {
    $('#mobile-nav').animate({
        width: 'toggle'
    });
    $('#page-wrap').toggleClass('thin');
});
$(".close-mobile-nav").click(function() {
    $('#mobile-nav').animate({
        width: 'toggle'
    });
    $('#page-wrap').removeClass('thin');
});


// Accordion
$(".accordion li").hover(function() {
    $(this).children('ul').slideToggle();
});

$('#faq .question').click(function() {
    $(this).toggleClass('active');
    $(this).next('#faq .answer').stop(true, true).slideToggle();
});

// Double Tap for Mobiles
$('.accordion li:has(ul)').doubleTapToGo();
$('#menu ul li:has(ul)').doubleTapToGo();


/* Moderniser Replace SVGs */

if (!Modernizr.svg) {
    $("img.svg").each(function() {
        var src = this.src.split(".");
        this.src = src[0] + ".png";
    });
}


// Disable all links that point to #hash
$(function() {
    $('a[href="#"]').click(function(event) {
        event.preventDefault();
    });
});


// Make Div Clickable using href
$('.clickable').filter(function() {
    if ($('a', this).attr('href')) {
        $(this).addClass('clickable');
        return true;
    }
    return false;
}).click(function() {
    var link = $(this).find('a:first'),
        href = link[0].href,
        target = link.attr('target');

    window.open(href, target || '_self');
});

$(".lightbox").fancybox({
    loop       : true,
    fitToView  : true,
    mouseWheel : false,
    autoSize   : true,
    autoResize : true,
    closeClick : true,
    maxWidth   : 800,
    minHeight  : 150,
    maxHeight  : 700,
    overlay    : { showEarly  : true },
    padding    : 0,
    height  : 'auto',
    helpers : {
        title    : { type : 'inside' }, 
        css : { borderColor: '#FFF' }
    }
});


// Slide in items
if ($(window).width() > 767) {
    $(document).ready(function() {
        $(window).fadeThis({
            baseName: "slide-",
            speed: 500,
            easing: "swing",
            offset: 0,
            reverse: false,
            distance: 100,
            scrolledIn: null, // Function to call when the element come in viewport.
            scrolledOut: null // Function to call when the element go out of the viewport.
        });
    });
}

// Parallax for slideshow
$(document).ready(function() {
  if ($(window).width() > 959) {
    var parallax = document.querySelectorAll(".parallax");
    var speed = 2;
    
    window.onscroll = function() {
      var yOffset = window.pageYOffset;
    
      for(var i = 0; i < parallax.length; i++){
        parallax[i].style.backgroundPosition = "0px " + (yOffset / speed) + "px";
      }
    }
  }
});

/* Replace all SVG images with inline SVG */
$('img.svg').each(function(){
    var $img = $(this);
    var imgID = $img.attr('id');
    var imgClass = $img.attr('class');
    var imgURL = $img.attr('src');

    $.get(imgURL, function(data) {
        // Get the SVG tag, ignore the rest
        var $svg = $(data).find('svg');

        // Add replaced image's ID to the new SVG
        if(typeof imgID !== 'undefined') {
            $svg = $svg.attr('id', imgID);
        }
        // Add replaced image's classes to the new SVG
        if(typeof imgClass !== 'undefined') {
            $svg = $svg.attr('class', imgClass+' replaced-svg');
        }

        // Remove any invalid XML tags as per http://validator.w3.org
        $svg = $svg.removeAttr('xmlns:a');

        // Replace image with new SVG
        $img.replaceWith($svg);

    }, 'xml');
});


// Forms
$('form').each(function() { this.reset() });

$(".datepicker").datepicker({
    changeMonth: true,
    changeYear: true,
    dateFormat: 'dd/mm/yy'
});


$(document).ready(function(){
    var email = $('.email'),
        confirm = $('.email-confirm');

    if(email.length && confirm.length){
        email.add(confirm).on('keyup', function(){
            if(email.hasClass('touched') && confirm.hasClass('touched')){
                confirm.closest('div').toggleClass('match', email.val() != confirm.val());
            }

            $(this).addClass('touched');
        });
    }
});

$('.submit').click(function() {
    $('.required').closest('li').removeClass('error').filter(function() {
            return !$.trim($(this).find('input,select').val()).length;
        })
        .addClass('error');
    $('.required').on('input change', function() {
        $(this).closest('li').removeClass('error');
    });
});

// Clickable table row 
$(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.document.location = $(this).data("href");
    });
});

// add selected tick
$(document).ready(function() {

     var total = 0,
        price = {},
        $total = $('.total'),
        $totalInput = $('#total-hidden'),
        format = function(){
            return  total.toFixed(2);
        },
        updateTotal = function(){

            var newprice = 0;
            for (var name in price) {
                if(price.hasOwnProperty(name)){
                    newprice += parseFloat(price[name]);
                }
            };

            if(total != newprice){
                total = newprice;

                $total.find('span').html(format())
                    .end().parent('.col')
                    .removeClass('highlight');

                $totalInput.val(format());

                setTimeout(function(){                    
                    $total.parent('.col').addClass('highlight');
                }, 1);
            }
        };

    $('input.input-box').addClass('js')
        .filter(':checked')
        .siblings('label.label-box').addClass('active')
        .each(function(){
            if($(this).attr('data-more-target')){
                $($(this).attr('data-more-target')).show();
            }
        });

    $('label.label-box').addClass('js').prepend('<div class="tick"></div>').on('click', function() {
        var elm = $(this),
            input = $('#' + elm.attr('for'));

        if(input.length){
            var cost  = parseFloat(input.attr('data-cost'));
            if(!isNaN(cost)){
                price[input.attr('name')] = cost;
            }

            $('[name="' + input.attr('name') + '"]')
                .not(input)
                .siblings('label.label-box')
                .removeClass('active')
                .addClass('touched')
                .each(function(){
                    if($(this).attr('data-more-target')){
                        $($(this).attr('data-more-target')).hide()
                            .find(':input').each(function(){
                                price[this.name] = 0;
                            });
                    }
                });
        } else {
            return true;
        }

        if(elm.attr('data-more-target')){
            $(elm.attr('data-more-target')).show()
                .find('label.label-box.active').each(function(){
                    var input = $('#' + $(this).attr('for'));
                    if(input.length){

                        var cost  = parseFloat(input.attr('data-cost'));
                        if(!isNaN(cost)){
                            price[input.attr('name')] = cost;
                        }
                    }
                });
        }


        //on change
        setTimeout(function(){
            var cache = {};
            
            elm.parents('.form-option-group').each(function(){
                var valid = true;

                $(this).find('input[required]').each(function(){
                    if(cache[this.name] === undefined && $(this).hasClass('touched')){
                        if(this.type == 'checkbox' || this.type == 'radio'){

                            if($(this).next('.label-box').is(':visible') && !$('[name="' + this.name + '"]:checked').length){
                                valid = false;
                                cache[this.name] = false;
                            } else {
                                cache[this.name] = true;
                            }
                        } else if($(this).is(':visible') && $(this).val() != '') {
                            valid = false;
                            cache[this.name] = valid;
                        } else if(this.type == 'email' && $(this).is(':visible') && !/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test($(this).val())){
                            valid = false;
                            cache[this.name] = valid;
                        }
                    }
                });
        
                if(valid){
                    $(this).find('select[required]:visible, textarea[required]:visible').each(function(){
                        if($(this).hasClass('touched') && !$(this).val()){
                            valid = false;
                        }
                    });
                }

                $(this).removeClass('complete incomplete').addClass(valid ? 'complete' : 'incomplete');
            })

            if(!window.applyInfo){
                $('#tabs').trigger('validate');
            }

        }, 1);


        $(this).addClass('active');

        updateTotal();
    });

    $(':input:not(.js)').on('change', function(){
        var elm = $(this);

        elm.addClass('touched');

        if(this.tagName.toUpperCase() == 'SELECT'){
            var option = elm.children(':selected'),
                cost = parseFloat(option.attr('data-cost'));

            if(!isNaN(cost)){
                price[this.name] = ($(this).is(':visible') || window.applyInfo) ? cost : 0;
            }
        
            if(elm.hasClass('more-dropdown')) {

                elm.children().filter('[data-more-target]').filter(':not(:selected)').each(function(){        
                    $($(this).attr('data-more-target')).hide()
                        .find(':input').each(function(){
                            price[this.name] = 0;
                        })
                        .end().find(window.applyInfo ? ':not(.notexist)' : '.touched').trigger('change')

                }).end().filter(':selected').each(function(){

                    if(elm.is(':visible') || window.applyInfo){
                        $($(this).attr('data-more-target')).show()
                            .find('label.label-box.active').each(function(){
                                var input = $('#' + $(this).attr('for'));
                                if(input.length){
                                    var cost  = parseFloat(input.attr('data-cost'));
                                    if(!isNaN(cost)){
                                        price[input.attr('name')] = cost;
                                    }
                                }
                            })
                            .end().find(window.applyInfo ? ':not(.notexist)' : '.touched').trigger('change')
                    } else {
                        $($(this).attr('data-more-target')).hide()
                            .find(':input').each(function(){
                                price[this.name] = 0;
                            })
                            .end().find(window.applyInfo ? ':not(.notexist)' : '.touched').trigger('change')
                    }
                })
            }
        }

        //on change
        setTimeout(function(){
            var cache = {};
            
            elm.parents('.form-option-group').each(function(){
                var valid = true;

                $(this).find('input[required]').each(function(){
                    if(cache[this.name] === undefined && $(this).hasClass('touched')){
                        if(this.type == 'checkbox' || this.type == 'radio'){

                            if($(this).next('.label-box').is(':visible') && !$('[name="' + this.name + '"]:checked').length){
                                valid = false;
                                cache[this.name] = false;
                            } else {
                                cache[this.name] = true;
                            }
                        } else if($(this).is(':visible') && $(this).val() == '') {
                            valid = false;
                            cache[this.name] = valid;
                        } else if(this.type == 'email' && $(this).is(':visible') && !/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test($(this).val())){
                            valid = false;
                            cache[this.name] = valid;
                        }
                    }
                });
        
                if(valid){
                    $(this).find('select[required]:visible, textarea[required]:visible').each(function(){
                        if($(this).hasClass('touched') && !$(this).val()){
                            valid = false;
                        }
                    });
                }

                $(this).removeClass('complete incomplete').addClass(valid ? 'complete' : 'incomplete');
            })

            if(!window.applyInfo){
                $('#tabs').trigger('validate');
            }

        }, 1);

        updateTotal();
    });

    //jquery tab
    (function () {

        var validate = function(tab, panel, quick){
            var content = $(panel),
                cache = {},
                valid = true,
                show  = false;

            content.find('input[required]').each(function(){
                if(cache[this.name] === undefined){

                    if(this.type == 'checkbox' || this.type == 'radio'){
                        if($(this).next('.label-box').is(':visible') && !$('[name="' + this.name + '"]:checked').length){
                            valid = false;
                            cache[this.name] = false;

                            show = (!quick && $(this).closest('.form-option-group').addClass('incomplete').length) || show;
                        } else {
                            cache[this.name] = true;
                        }

                    } else if($(this).is(':visible') && $(this).val() == '') {
                        valid = false;
                        cache[this.name] = valid;
                        show = (!quick && $(this).closest('.form-option-group').addClass('incomplete').length) || show;
                    } else if(this.type == 'email' && $(this).is(':visible') && !/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test($(this).val())){
                        valid = false;
                        cache[this.name] = valid;
                        show = (!quick && $(this).closest('.form-option-group').addClass('incomplete').length) || show;
                    }
                }

                if(quick && !valid){
                    return false;
                }
            });

            if(valid || !show){
                content.find('select[required]:visible, textarea[required]:visible').each(function(){
                    if(!$(this).val()){
                        valid = false;
                        !quick && $(this).closest('.form-option-group').addClass('incomplete');
                    }

                    if(quick && !valid){
                        return false;
                    }
                });
            }

            if(!quick || valid){
                $(tab).removeClass('complete incomplete').addClass(valid ? 'complete' : 'incomplete');

                /*
                if($(tab).is(':last-child')){
                    $('#form-incomplete').toggleClass('hidden', valid);
                    $('#form-complete').toggleClass('hidden', !valid);
                }
                */
            }
        }

        var $tabs = $('#tabs').tabs({
            beforeActivate: function(event, ui){
                if(ui.oldTab){
                    validate(ui.oldTab, ui.oldPanel, false);
                }

                if(ui.newTab && ui.newTab.is(':last-child')){
                    var valid = ui.newTab.parent().find('.incomplete').not(ui.newTab).length == 0;

                    $('#form-incomplete').toggleClass('hidden', valid);
                    $('#form-complete').toggleClass('hidden', !valid);
                }
            }
        }).on('validate', function(e, data){
            var index = $tabs.tabs('option', 'active'),
                tab = $tabs.find('.ui-tabs-nav > li:eq(' + index + ')'),
                panel = $tabs.find('.ui-tabs-panel:eq(' + index + ')');

            validate(tab, panel, typeof data != 'undefined' ? data : true);
        });


        //next/prev
        var $panel = $('.ui-tabs-panel'),
            nextOriginal = $('.next-tab.hidden'),
            prevOriginal = $('.prev-tab.hidden');

        $panel.each(function (i) {
            var totalSize = $panel.size() - 1;

            if (i != totalSize) {
                next = i + 1;
                $(this).append('<hr>').append(nextOriginal.clone().removeClass('hidden').attr('rel', next));
            }

            if (i != 0) {
                prev = i - 1;
                $(this).append(prevOriginal.clone().removeClass('hidden'));
            }
        }).on('validate', function(){
            validate($tabs.find('.ui-tabs-nav > li:eq(' + $(this).index() + ')'), $(this), false);
        });

        $('.next-tab, .prev-tab').on('click', function (e) {
            $tabs.tabs('option', 'active', $(this).attr('rel'));
            $('#scroll-to-here').length && $('html, body').animate({scrollTop: $('#scroll-to-here').offset().top -20 }, 'slow');
        });

        //trigger validate
        $('#complete-order').on('click', function(){
            $('#tabs').trigger('validate', false);
        });

    })();


    //submit order
    (function(){
        function submit(){

            var button = $('#complete-order');

            //has error
            if($('#tabs').children('.tabs-menu').children('.incomplete').length) {
                button.removeClass('submiting');
                return false;
            }

            //send email case
            if(button.hasClass('email')){
                var group = button.closest('.form-option-group'),
                    valid = group.find(['[required]']).filter(function(){
                        return !$(this).val()
                    }).length == 0;

                if(valid){
                    var email = group.find('[name="customer-email"]'),
                        confirm = group.find('[name="customer-email-confirm"]');

                    if(!/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(email.val())){
                        valid = false;
                    }

                    if(email.val() != confirm.val()){
                        valid = false;
                    }
                }

                group.removeClass('complete incomplete').addClass(valid ? 'complete' : 'incomplete');

                if(!valid){
                    button.removeClass('submiting');
                    return false;
                }
            }

            var r20 = /%20/g,
                rbracket = /\[\]$/,
                rCRLF = /\r?\n/g,
                rsubmitterTypes = /^(?:submit|button|image|reset|file)$/i,
                rsubmittable = /^(?:input|select|textarea|keygen)/i,
                rcheckableType = (/^(?:checkbox|radio)$/i),
                form = $('#order-form'),
                elements = form.map(function() {
                    // Can add propHook for "elements" to filter or add form elements
                    var elements = $.prop( this, "elements" );
                    return elements ? $.makeArray( elements ) : this;
                })
                .filter(function() {
                    var type = this.type;
                    // Use .is(":disabled") so that fieldset[disabled] works
                    return this.name && !$( this ).is( ":disabled" ) &&
                        rsubmittable.test( this.nodeName ) && !rsubmitterTypes.test( type ) &&
                        ( this.checked || !rcheckableType.test( type ) );
                })
                .map(function( i, elem ) {
                    var val = $( this ).val(),
                        cost = $(this).data('cost');

                    if(this.tagName.toUpperCase() == 'SELECT'){
                        cost = $(this).children(':selected').attr('data-cost');
                    }

                    return val == null ?
                        null :
                        $.isArray( val ) ?
                            $.map( val, function( val ) {
                                return { name: elem.name, value: val.replace( rCRLF, "\r\n" ), cost: cost, label: $(this).data('label') };
                            }) :
                            { name: elem.name, value: val.replace( rCRLF, "\r\n" ), cost: cost, label: $(this).data('label') };
                }).get();

            elements.push({
                name: 'data',
                value: JSON.stringify(elements)
            });

            $.post(form.attr('action'), elements).done(function(rsp){
                if(typeof rsp == 'string'){
                    try {
                        rsp = $.parseJSON(rsp);
                    } catch (e) {}
                }

                if(rsp && rsp.message){

                    alert(rsp.message);

                } else if(rsp && rsp.error){
                    var errors = [];

                    if($.isPlainObject(rsp.error)){
                        for(var p in rsp.error){
                            errors = errors.concat(rsp.error[p]);
                        }
                    } else if(typeof rsp.error == 'string'){
                        errors.push(rsp.error);
                    } else if($.isArray(rsp.error)){
                        errors = rsp.error;
                    }
                    
                    alert(errors.join("\n"));
                }

            }).fail(function(xhr){
                if(xhr && xhr.status >= 400 && xhr.responseText){
                    alert(xhr.responseText);
                }
            }).always(function(){
                button.removeClass('submiting');
            });

            return false;
        };

        $('#complete-order').on('click', function(){
            if($(this).hasClass('submiting')){
                return false;
            }
            $(this).addClass('submiting');
            
            setTimeout(submit, 100);
            
            return false;
        });
    })();

}); // End doc ready


//Initialize file upload
$(document).ready(function(){
    $('#photo1, #photo2, #photo3, #photo4').fileupload({
        url: BaseUrl + 'site/upload',
        dataType: 'json',
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        done: function (e, data) {
            $(this).siblings('.zhidden').val(data.result.files[0].url).trigger('change').closest('.col').find('.photo-preview').html('')
                .css('background-image', 'url(' + data.result.files[0].url + ')');

        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $(this).closest('.col').find('.photo-preview').html(progress + '%');
        }
    }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');

    $('#biomap-3d-file1').fileupload({
        url: BaseUrl + 'site/upload',
        dataType: 'json',
        acceptFileTypes: /(\.|\/)(pdf|doc|docx)$/i,
        done: function (e, data) {
            $(this).siblings('.zhidden').val(data.result.files[0].url).trigger('change')
                .siblings('.progr').find('.progr-file').html(data.result.files[0].name);
        },
        progress: function (e, data) {
            $(this).siblings('.progr')
                .find('.percent').html(parseInt(data.loaded / data.total * 100, 10) + '%')
                .end().find('.progr-file').html(data.files[0].name);
        }
    }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');
});


//Designer
$(document).ready(function(){
    $('#find-dealer-btn').on('click', function(){
        
        var valid = $(this).prevAll('[name="find-dealer"]').val();
        $(this).closest('.form-option-group').removeClass('complete incomplete').addClass(valid ? 'complete' : 'incomplete');

        if(valid){
            window.location.href = BaseUrl + 'find-dealer?keyword=' + encodeURIComponent(valid);
        }

        return false;
    });
});

//Dealer area
$(document).ready(function(){
    $('#search-form').on('change', 'select', function(){
        $('#search-form').submit();
    }).on('click', '.search-btn', function(){
        $('#search-form').submit();
        return false;
    }).on('submit', function(){
        $.pjax.reload({container: '#pjax-drysuits', data: $(this).serialize(), url: $(this).attr('action')});
        return false;
    });
});


//apply existing
$(window).load(function(){
    
    
    if(window.orderInfo){

        window.applyInfo = true;

        var container = $('#tabs'),
            inputs = container.find(':input'),
            elements = null,
            tagName = null;

        $.each(window.orderInfo, function(idx, info){
            elements = inputs.filter('[name="Order[' + info.name + ']"]');
                
            if(elements.length){
                tagName = elements.eq(0).prop('tagName').toUpperCase();

                if(tagName == 'SELECT'){
                    elements.val(info.value).trigger('change');
                } else if(tagName == 'INPUT' && (elements.eq(0).attr('type') == 'radio' || elements.eq(0).attr('type') == 'checked')){
                    elements.filter(function(){
                        return $(this).val() == info.value;
                    })
                    .prop('checked', true)
                    .trigger('change')
                    .filter('.js').siblings('.label-box').triggerHandler('click');
                } else if(info.name == 'photo1' || info.name == 'photo2' || info.name == 'photo3' || info.name == 'photo4') {
                    elements.val(info.value).closest('.col').find('.photo-preview').css('background-image', 'url(' + info.value + ')');
                } else if(info.name == 'biomap-3d-file') {
                    elements.val(info.value).siblings('.progr').find('.progr-file').html(info.value.substr(info.value.lastIndexOf('/') + 1));
                } else if(tagName == 'INPUT' || tagName == 'TEXTAREA'){
                    elements.val(info.value).trigger('change');
                }
            }
        });

        window.applyInfo = false;

        //quick validate
        $('#tabs').trigger('validate');
        $('.ui-tabs-panel').trigger('validate');
    }

});

$(document).ready(function() {
	$('.lightbox').fancybox({
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
	    helpers : {
	        title    : { type : 'inside' }, 
	        css : { borderColor: '#FFF' }
	    }
	});	
});

//Dealer import file upload
$(document).ready(function(){
    $('#import-dealer').fileupload({
        url: BaseUrl + 'admin/dealer/upload',
        dataType: 'json',
        acceptFileTypes: /(\.|\/)(csv)$/i,
        send: function (e, data) {
            $('#uploading').removeClass('fa-plus').addClass('fa-refresh fa-spin');
        },
        done: function (e, data) {
            $.ajax({
                url: BaseUrl + 'admin/dealer/import',
                data: {'fileUrl': data.result.files[0].url},
                type: 'POST',
                success: function () {
                   window.location.reload();
                }
            });
        }
    });
});

//Product prices import file upload
$(document).ready(function(){
    $('#import-price').fileupload({
        url: BaseUrl + 'admin/price/upload',
        dataType: 'json',
        acceptFileTypes: /(\.|\/)(csv)$/i,
        send: function (e, data) {
            $('#uploading').removeClass('fa-plus').addClass('fa-refresh fa-spin');
        },
        done: function (e, data) {
            $.ajax({
                url: BaseUrl + 'admin/price/import',
                data: {'fileUrl': data.result.files[0].url},
                type: 'POST',
                success: function () {
                   window.location.reload();
                }
            });
        }
    });
});

//Change on/off dealer show on map/result
$(document).ready(function(){
    $('.change_show_on').click(function(){
        $.ajax({
            url: BaseUrl + 'admin/dealer/change-show-on',
            data: {'id': $(this).data("value")},
            type: 'POST',
        });
    });
});

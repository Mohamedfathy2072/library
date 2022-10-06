$(document).ready(function () {
    $(".mydiv").animate({
        left: "40%",
        top: "15%",
        height: "20px"
        
    }, 1000);
    $(".mydiv").animate({
        left: "34%",
        width: "500px",
        borderRadius: "10px"

    }, 1000);
    $(".mydiv").animate({
       
        height: "532px",
        borderRadius: "20px"
    }, function () {
        $(".h").fadeIn("slow");
    });
    $(".mydiv").animate({
        width: "500px"
    }, function () {
        $(".myForm").fadeIn("slow");
    });
    'use strict';
    // hide placeholder on form focus
        $('[placeholder]').focus(function () {
        $(this).attr('data-text', $(this).attr('placeholder'));
        $(this).attr('placeholder', '');
        })
    .blur(function () {
    $(this).attr('placeholder', $(this).attr('data-text'));
    });
    //add asterisk on requrired field
    // $('input').each(function () {
    //     if ($(this).attr('required') === 'required') {
    //         $(this).after('<span class="asterisk">*</span>');
    //    }

    // });
    //confirmation message
    $('.confirm').click(function() {
        return confirm('are you sure ?');
    });
    //view option
    $('.catname h5').click(function () {
        $(this).next('.listcat').fadeToggle(200);
    });
    $('.subcat').hover(function () {
        $(this).find('.deletesub').fadeIn(200);
    }, function () { 

        $(this).find('.deletesub').fadeOut(200);
    });
    
    $('.live-name').keyup(function () {
         $('.live-review h5').text($(this).val());
     });
    $('.live-description').keyup(function () {
         $('.live-review .1').text($(this).val());
    });

$('.live-price').keyup(function () {
    $('.live-review span').text($(this).val());

});
$('.live-author').keyup(function () {
    $('.live-review p').text($(this).val());

});
$('.live-img').keyup(function () {
    $('.live-review img').text($(this).val());

});
});
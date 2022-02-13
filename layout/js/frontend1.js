$(function(){
    "use strict";
    /* switch between login & signup */
    $(".login-page h1 span").click(function() {
        $(this).addClass("selected").siblings().removeClass("selected");
        $(".login-page form").hide();
        $("." + $(this).data("class")).fadeIn(100);
    })

    /* Trigger the selectbox it */
    $("select").selectBoxIt({
        autoWidth: false
    })
    // To Hide The Placeholder
    var x
    $("input.form-control").focus(function(){
        x = $(this).attr("placeholder");
        $(this).attr("placeholder", " ");
    });
    $("input.form-control").blur(function(){
        $(this).attr("placeholder", x);
    });
    //Add Asterisk on required field
    $("input").each(function(){
        if($(this).attr('required') === 'required'){
            $(this).after("<span class='asterisk'>*</span>");
        }
    });

    // confirmation message on delete button
    $('.confirm').click(function() {
        return confirm('Are you sure?');
    });


    $(".live").keyup(function() {
        $($(this).data("class")).text($(this).val());
    });

});

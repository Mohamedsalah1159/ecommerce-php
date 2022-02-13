$(function(){
    "use strict";
    /* Dashboard */
    $(".toggle-info").click(function() {
        $(this).toggleClass("selected").parent().next(".panel-body").fadeToggle(200);
        if($(this).hasClass("selected")){
            $(this).html('<span class="toggle-info">-</span>');
        }else{
            $(this).html('<span class="toggle-info">+</span>');
            
        }
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
    //convert password field to text field on hover
    $(".show-pass").hover(function(){
        $(".password").attr('type', 'text');
    },function(){
        $(".password").attr('type', 'password');
    });
    // confirmation message on delete button
    $('.confirm').click(function() {
        return confirm('Are you sure?');
    });
    /* category view option*/
    $(".cat h3").click(function() {
        $(this).next(".full-view").fadeToggle(200);
    });
    $(".option span").click(function() {
        $(this).addClass("active").siblings("span").removeClass("active");
        if($(this).data("view") === "full"){
            $(".cat .full-view").fadeIn(200);
        }else{
            $(".cat .full-view").fadeOut(200);
        }
    });
    // show delete button on child cats
    $(".categories .child-link").hover(function() {
        $(this).find(".show-delete").fadeIn(300);
    },function() {
        $(this).find(".show-delete").fadeOut(300);
    })
});
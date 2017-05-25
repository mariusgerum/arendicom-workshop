var AjAX_Running = false;

$(document).on('click', '.ajax', function (e) {
    if (AjAX_Running == true) {
        return false;
    }
    AjAX_Running = true;

    /* Prevent default form behavior */
    e.preventDefault();

    var ClickedElement = $(this);
    var ClickedElementText = $(ClickedElement).html();
    if ($(this).hasClass('clear-container')) {
        $($(ClickedElement).attr('data-rc')).html("");
    }

    if ($(ClickedElement).find('i.fa').length == 0) {
        $(ClickedElement).html("<i class='fa fa-refresh fa-spin'></i> " + ClickedElementText);
    } else {
        $(ClickedElement).find('i.fa').attr('class', 'fa fa-refresh fa-spin');
    }

    $($(ClickedElement).attr('data-rc')).html($(ClickedElement).attr('data-initial'));


    var DataURL = "";
    var DataURLAttribute = $(this).attr('data-url');
    if (typeof DataURLAttribute !== typeof undefined && DataURLAttribute !== false) {
        DataURL = $(ClickedElement).attr('data-url');
        DataURL = DataURL.replace(/^\&/i, '');
        DataURL = "&" + DataURL;
    }

    if ($(this).hasClass('trigger-alt')) {
        CustomTriggerClass = '.alt-trigger';
    }

    jQuery.ajax({
        url: "/index.php?ajax&action=" + $(ClickedElement).attr('data-action') + DataURL,
        type: "GET",
        processData: false,
        contentType: false,
        success: function (data) {
            $(ClickedElement).html(ClickedElementText);
            $($(ClickedElement).attr('data-rc')).html(data);

            // Hide messages
            // $($(ClickedElement).attr('data-rc') + ' .alert-danger').delay(1000).fadeOut("slow");

            // Sets focus to element with autofocus attribute
            $($(ClickedElement).attr('data-rc') + ' *[autofocus]').trigger('focus');

            window.setTimeout(function () {
                jQuery('.fixed-alert').hide();
            }, 4000);

            AjAX_Running = false;
            $($(ClickedElement).attr('data-tc')).trigger('click');

            if ($(ClickedElement).hasClass('scroll2')) {
                $('html,body').animate({
                    scrollTop: $($(ClickedElement).attr('data-rc')).offset().top
                }, 250);
            }

        }
    });
});

/**
 * AjAX form submit
 */
$(document).on('click', '.ajax-submit', function (e) {

    /* Check if an ajax request is currently running (if so, return false) */
    if (AjAX_Running == true) {
        return false;
    }

    AjAX_Running = true;

    /* Prevent default form behavior */
    e.preventDefault();

    /* Clicked element */
    var ClickedElement = $(this);
    var ClickedElementText = $(ClickedElement).html();
    if ($(this).hasClass('clear-container')) {
        $($(ClickedElement).attr('data-rc')).html("");
    }

    $($(ClickedElement).attr('data-rc')).addClass('no-pointer-events');

    /* Set up custom GET parameters */
    var DataURL = "";
    var DataURLAttribute = $(this).attr('data-url');
    if (typeof DataURLAttribute !== typeof undefined && DataURLAttribute !== false) {
        DataURL = $(ClickedElement).attr('data-url');
        DataURL = DataURL.replace(/^\&/i, '');
        DataURL = "&" + DataURL;
    }

    if ($(ClickedElement).find('i.fa').length == 0) {
        $(ClickedElement).html("<i class='fa fa-refresh fa-spin'></i> " + ClickedElementText);
    } else {
        $(ClickedElement).find('i.fa').attr('class', 'fa fa-refresh fa-spin');
    }

    if ($(this).hasClass('trigger-alt')) {
        CustomTriggerClass = '.alt-trigger';
    }

    $.post("/index.php?ajax&action=" + $(ClickedElement).attr('data-action') + DataURL, $($(ClickedElement).attr('data-form')).serialize(), function (data) {

        $($(ClickedElement).attr('data-rc')).removeClass('no-pointer-events');

        $(ClickedElement).html(ClickedElementText);

        $($(ClickedElement).attr('data-rc')).html(data);

        // Hide messages
        // $($(ClickedElement).attr('data-rc') + ' .alert-danger').delay(1000).fadeOut("slow");

        // Sets focus to element with autofocus attribute
        $($(ClickedElement).attr('data-rc') + ' *[autofocus]').trigger('focus');

        window.setTimeout(function () {
            jQuery('.fixed-alert').hide();
        }, 2500);

        AjAX_Running = false;
        $($(ClickedElement).attr('data-tc')).trigger('click');
        if ($(ClickedElement).hasClass('scroll2')) {
            $('html,body').animate({
                scrollTop: $($(ClickedElement).attr('data-rc')).offset().top
            }, 250);
        }

    });

    if ($(this).hasClass('scroll2top')) {
        // location.href = '#body';
        location.hash = '#body';
    }
});


/**
 * AjAX form submit
 */
$(document).on('click', '.ajax-upload', function (e) {

    /* Check if an ajax request is currently running (if so, return false) */
    if (AjAX_Running == true) {
        return false;
    }

    AjAX_Running = true;

    /* Prevent default form behavior */
    e.preventDefault();

    /* Clicked element */
    var ClickedElement = $(this);
    var ClickedElementText = $(ClickedElement).html();
    if ($(this).hasClass('clear-container')) {
        $($(ClickedElement).attr('data-rc')).html("");
    }

    /* Set up custom GET parameters */
    var DataURL = "";
    var DataURLAttribute = $(this).attr('data-url');
    if (typeof DataURLAttribute !== typeof undefined && DataURLAttribute !== false) {
        DataURL = $(ClickedElement).attr('data-url');
        DataURL = DataURL.replace(/^\&/i, '');
        DataURL = "&" + DataURL;
    }

    if ($(ClickedElement).find('i.fa').length == 0) {
        $(ClickedElement).html("<i class='fa fa-refresh fa-spin'></i> " + ClickedElementText);
    } else {
        $(ClickedElement).find('i.fa').attr('class', 'fa fa-refresh fa-spin');
    }

    $.ajax({
        url: "/index.php?ajax&action=" + $(ClickedElement).attr('data-action') + DataURL, // point to server-side PHP script
        dataType: 'html',  // what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: new FormData($($(ClickedElement).attr('data-form'))[0]),
        type: 'post',
        success: function (data) {
            $(ClickedElement).html(ClickedElementText);

            $($(ClickedElement).attr('data-rc')).html(data);

            // Hide messages
            // $($(ClickedElement).attr('data-rc') + ' .alert-danger').delay(1000).fadeOut("slow");

            // Sets focus to element with autofocus attribute
            $($(ClickedElement).attr('data-rc') + ' *[autofocus]').trigger('focus');

            AjAX_Running = false;
            $($(ClickedElement).attr('data-tc')).trigger('click');
            if ($(ClickedElement).hasClass('scroll2')) {
                $('html,body').animate({
                    scrollTop: $($(ClickedElement).attr('data-rc')).offset().top
                }, 250);
            }
        }
    });


    if ($(this).hasClass('scroll2top')) {
        // location.href = '#body';
        location.hash = '#body';
    }
});


/* @todo onclick in form */


$(document).on('submit', 'form', function (e) {
    e.preventDefault();
    //console.log($(this).attr('id'));
    $('#' + $(this).attr('id') + ' .ajax-submit').trigger('click');
})

/*
 $('.modal').on('shown.bs.modal', function () {
 setTimeout(function(){
 $('#'+$(this).attr('id')+' input[autofocus]').trigger('focus');
 }, 1000);
 })
 */

/*
 $('.modal').on('focus', function () {
 $('#'+$(this).attr('id')+' *[autofocus]').trigger('focus');
 })
 */

/*
 $("body select.bs-select").bind("DOMSubtreeModified", function() {
 alert("tree changed");
 });
 */

var CustomTriggerClass = false;

$('.modal').on('hidden.bs.modal', function () {
    var tc = '.trigger-on-modal-close';
    if (CustomTriggerClass !== false) {
        tc = CustomTriggerClass;
        CustomTriggerClass = false;
    }
    $(tc).trigger('click');
    $('#' + $(this).attr('id') + ' .rc-modal').html("");
})

jQuery('#forget-password').click(function () {
    jQuery('.login-form').hide();
    jQuery('.forget-form').show();
});

jQuery('#back-btn').click(function () {
    jQuery('.login-form').show();
    jQuery('.forget-form').hide();
});

jQuery('#register-btn').click(function () {
    jQuery('.login-form').hide();
    jQuery('.register-form').show();
});

jQuery('#register-back-btn').click(function () {
    jQuery('.login-form').show();
    jQuery('.register-form').hide();
});


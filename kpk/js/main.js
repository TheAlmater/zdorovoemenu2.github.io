$(document).ready(function () {
    
    $('header.header').each(function () {
        var hold = $(this);
        var menu = hold.find('.toggle-menu');
        var menuClass = 'open-menu';
        menu.click(function () {
            hold.toggleClass(menuClass);
        });
    });

    $(document).on('click', '[data-modal]', function (e) {
        e.preventDefault();

        $("#" + $(this).attr('data-modal')).modal('show');
    })
    .on('click', '.btn-close img', function () {
        $($(this).closest('.modal')).modal('hide');
    });

    $('.feature').hover(function() {
        if (window.innerWidth <= 992) { //893
            return;
        }
        $(this).find('.feature-overlay').addClass('active');
    }, function() {
        if (window.innerWidth <= 992) {
            return;
        }
        $(this).find('.feature-overlay').removeClass('active');
    });

    $('.feature').click(function() {
        if (!$(this).hasClass('active')) {
            $(this).find('.feature-overlay').addClass('active');
        }
    });

    $('.feature-overlay__btn').click(function(e) {
        e.stopPropagation();
        
        $(this).parents('.feature-overlay').removeClass('active');
    });

    $(".testimonials").owlCarousel({
        margin: 30,
        // animateOut: 'fadeOut',
        stagePadding: 0,
        loop: true,
        nav: true,
        items: 2,
        responsive: {
            0: {
                autoHeight: true,
                stagePadding: 30,
                margin: 15,
                items: 1,
                mouseDrag: true,
            },
            768: {
                autoHeight: false,
                mouseDrag: false,
                stagePadding: 0,
                margin: 15,
                items: 1
            },
            992: {
                mouseDrag: false,
                stagePadding: 0,
                margin: 30,
                items: 2
            },
        }
    });

    $('.testimonials-item__btn').click(function (e) {
        e.preventDefault();

        var i = $(this).attr('data-i');
        $('.modal-testimonails .testimonials-item-' + i)
            .css('display', 'block')
            .siblings('.testimonials-item')
            .css('display', 'none');
    });

    $('.lessons').owlCarousel({
        margin: 30,
        animateOut: 'fadeOut',
        loop: true,
        nav: true,
        responsive: {
            0: {
                stagePadding: 30,
                margin: 15,
                items: 1
            },
            375: {
                stagePadding: 50,
                margin: 15,
                items: 1
            },
            500: {
                stagePadding: 100,
                items: 1
            },
            600: {
                stagePadding: 140,
                items: 1
            },
            710: {
                stagePadding: 80,
                items: 2
            },
            992: {
                stagePadding: 0,
                items: 3
            }
        }
    });

    jQuery(document).ready(function ($) {
        $('#play').mediaelementplayer();
    });

    $(document).on('click', "[data-url]:not([data-post])", function () {
        location.href = $(this).attr('data-url');
    });

    $(document).on("submit", "[data-form='capcha']", function (e) {
        e.preventDefault();

        if ($("input[name='ok_form']", this).length) {
            if (! $("input[name='ok_form']", this).prop('checked')) {
                $(".a_poly", this).addClass('error');
                return false;
            } else {
                $(".a_poly", this).removeClass('error');
            }
        }
        var submiting = true;
        $('form').each(function () {
            if ($(this).attr('submiting') === '1') {
                submiting = false;
            }
        });
        if (! submiting) {
            return false;
        }

        $(this).attr('submiting', 1);
        $.ajax({
            type: 'GET',
            url: '/capha_3.php',
            context: $(this),
            dataType: 'json',
            success: function (data) {
                $(this).append(
                    $("<input>", {
                        type: 'hidden',
                        name: 'capcha_3_' + data.n,
                        value: eval(data.s)
                    })
                ).attr('submiting', 2);

                $.ajax({
                    type: 'POST',
                    url: '/send.php',
                    context: $(this),
                    data: $(this).serialize(),
                    dataType: 'JSON',
                    success: function (data) {
                        if (data.error == '1') {
                            if (typeof data.fields != 'undefined') {
                                for (var p in data.fields) {
                                    $("[name='" + p + "']", this).addClass('error').focus()
                                        .on('input.in_fo_on_t change.in_fo_on_t', function () {
                                            $(this).removeClass('error').off('.in_fo_on_t');
                                            $(".list_error[data-for='" + $(this).attr('name') + "']")
                                                .removeClass('filled').html('');
                                        });

                                    $(".list_error[data-for='" + p + "']").addClass('filled').html('')
                                        .append($("<li>").html(data.fields[p]));
                                }
                            }
                        } else {
                            $("input, textarea", this).each(function () {
                                if($(this).attr('name') !== 'send') {
	                                $(this).removeClass('error').val('');
                                }
                            });

                            $('.modal').each(function () {
                                $(this).modal('hide');
                            });

                            setTimeout(function() {
	                            $('#modal_mini_info .text_info').html(data.message);

	                            $('#modal_mini_info').modal('show').on('hide.bs.modal', function() {
	                                setTimeout(function() {
		                                $('body').css('padding-right', 0);
                                    }, 100);
	                            });
                            }, 300);

                        }
                    }
                });
            }
        });
    });

    setInterval(function() {
	    $('body').css('padding-right', 0);
    }, 300);
});
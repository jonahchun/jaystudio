$(function() {
    new Swiper('.js-img-tpl', {
        observer: true,
        observeParents: true,
        slidesPerView: 'auto',
        spaceBetween: 20,
        freeModeSticky: true,
        scrollbar: {
            el: '.js-img-tpl .js-img-tpl-scrollbar',
            hide: false,
        }
    });

    new Swiper('.js-img-tpl-4', {
        observer: true,
        observeParents: true,
        slidesPerView: 4,
        spaceBetween: 20,
        scrollbar: {
            el: '.js-img-tpl-4 .js-img-tpl-scrollbar',
            hide: false,
        },
    });

    // content tabs init
    $('.js-tabset').tabset({
        tabLinks: 'a',
        addToParent: true,
        defaultTab: true
    });

    $('.js-tabset-alt').tabset({
        tabLinks: 'a',
        defaultTab: true
    });

    // Accordion init
    $('.js-faq-accordion').openClose({
        accordion: true,
        activeClass: 'is-active',
        opener: '> .js-faq-opener',
        slider: '> .js-faq-slider',
        animSpeed: 400,
        effect: 'slide'
    });

    // === sidebar menu activation js
    for (var i = window.location.origin + window.location.pathname, o = $(".main-nav a").filter(function() {
        return this.href == i;
    }).addClass("is-active").parent().addClass("is-active"); ;) {
        if (!o.is("li")) break;
        o = o.parent().addClass("in").parent().addClass("is-active");
    }
    $(".js-newlywed-avatar-input").change(function() {
        if(this.files && this.files[0]) {
            var reader = new FileReader();
            var image = $(this).closest('.js-newlywed-avatar').first().find('img');
            reader.onload = function(e) {
                image.attr('src', e.target.result);
                image.addClass('uploaded');
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    // body load class
    setTimeout(function(){
        $('body').addClass('loaded');
    }, 500);

    // jquery validate
    $('.js-validate').validate();
});

window.confirmSetLocation = function(urlLink) {
    $("#confirm-action").modal('show');
    $("#confirm-action .btn-primary").click(function() {
        window.location.href = urlLink;
    });
};


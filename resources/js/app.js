/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
//
// window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// const app = new Vue({
//     el: '#app',
// });

(function ($) {

    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-133353264-2', { 'anonymize_ip': true });


    $("#back_btn").click(function (){
        window.history.back();
    });

    $('[handle-logout]').click(function () {
        event.preventDefault();
        document.getElementById('logout-form').submit();
    });

    const dangerZone = $('form.danger-zone');

    if (dangerZone) {
        const submitButton = dangerZone.find('button[type=submit]');
        const submitText = submitButton.text();

        let dangerCounter = 3;
        submitButton.attr('disabled', 'disabled');
        submitButton.text(submitText + ' (' + dangerCounter + ')');


        const dangerInterval = setInterval(function () {
            dangerCounter--;
            submitButton.text(submitText + ' (' + dangerCounter + ')');

            if(dangerCounter == 0) {
                submitButton.removeAttr('disabled');
                submitButton.text(submitText);
                clearInterval(dangerInterval);
            }
        }, 1000);

    }

    $('.js-tooltip').tooltip();
    const copyToClipboard = (text, el) => {
        const copyTest = document.queryCommandSupported('copy');
        const elOriginalText = el.attr('data-original-title');

        if (copyTest === true) {
            const copyTextArea = document.createElement("textarea");
            copyTextArea.value = text;
            document.body.appendChild(copyTextArea);
            copyTextArea.select();
            try {
                const successful = document.execCommand('copy');
                const msg = successful ? 'Copied!' : 'Whoops, not copied!';
                el.attr('data-original-title', msg).tooltip('show');
            } catch (err) {
                console.log('Oops, unable to copy');
            }
            document.body.removeChild(copyTextArea);
            el.attr('data-original-title', elOriginalText);
        } else {
            // Fallback if browser doesn't support .execCommand('copy')
            window.prompt("Copy to clipboard: Ctrl+C or Command+C, Enter", text);
        }
    }
    // Copy to clipboard
    // Grab any text in the attribute 'data-copy' and pass it to the
    // copy function
    $('.js-copy').click(function() {
        var text = $(this).attr('data-copy');
        var el = $(this);
        copyToClipboard(text, el);
    });
})(jQuery);

!function(t){"use strict";t("#sidebarToggle, #sidebarToggleTop").on("click",function(o){t("body").toggleClass("sidebar-toggled"),t(".sidebar").toggleClass("toggled"),t(".sidebar").hasClass("toggled")&&t(".sidebar .collapse").collapse("hide")}),t(window).resize(function(){t(window).width()<768&&t(".sidebar .collapse").collapse("hide")}),t("body.fixed-nav .sidebar").on("mousewheel DOMMouseScroll wheel",function(o){if(768<t(window).width()){var e=o.originalEvent,l=e.wheelDelta||-e.detail;this.scrollTop+=30*(l<0?1:-1),o.preventDefault()}}),t(document).on("scroll",function(){100<t(this).scrollTop()?t(".scroll-to-top").fadeIn():t(".scroll-to-top").fadeOut()}),t(document).on("click","a.scroll-to-top",function(o){var e=t(this);t("html, body").stop().animate({scrollTop:t(e.attr("href")).offset().top},1e3,"easeInOutExpo"),o.preventDefault()})}(jQuery);

$('form .submit-link').on({
    click: function (event) {
        event.preventDefault();
        $(this).closest('form').submit();
    }
});

document.addEventListener('DOMContentLoaded', function () {
    if (typeof $$ === 'function' && typeof $$.fn.magnificPopup === 'function') {
        $$('.display-watch__card-video-link').each(function (linkIndex, linkNode) {
            $$(linkNode).magnificPopup({
                type: 'iframe'
            });
        });
    }
});

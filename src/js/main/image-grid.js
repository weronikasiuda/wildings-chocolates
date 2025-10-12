// Image grid lightbox effect
// https://dimsemenov.com/plugins/magnific-popup/
document.addEventListener('DOMContentLoaded', function () {
    if (typeof $$ === 'function' && typeof $$.fn.magnificPopup === 'function') {
        $$('.image-grid').each(function (gridIndex, gridNode) {
            $$(gridNode).magnificPopup({
                type: 'image',
                delegate: 'a',
                gallery: {
                    enabled: true
                }
            });
        });
    }
});

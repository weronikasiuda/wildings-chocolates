// Product image lightbox
// https://dimsemenov.com/plugins/magnific-popup/
document.addEventListener('DOMContentLoaded', function () {
    if (typeof $$ === 'function' && typeof $$.fn.magnificPopup === 'function') {
        $$('.woocommerce-product-gallery').magnificPopup({
            type: 'image',
            delegate: 'a',
            gallery: {
                enabled: true
            }
        });
    }
});

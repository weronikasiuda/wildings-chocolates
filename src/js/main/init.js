// Add a class to the root element immediately to signify that JavaScript has
// loaded and has been parsed.
document.documentElement.classList.add('js');

// jQuery/Zepto
var $$;

if (typeof $ === 'function') {
    $$ = $;
} else if (typeof jQuery === 'function') {
    $$ = jQuery;
} else if (typeof Zepto === 'function') {
    $$ = Zepto;
}

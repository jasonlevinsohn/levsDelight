$(document).ready(function() {



});

$(function() {
    var $ibWrapper = $('#ib-main-wrapper'),
        
        Template = (function() {
            var kinectic_moving = false,
                current         = -1,
                isAnimating     = false,
                $ibItems        = $ibWrapper.find('div.ib-main > a'),
                $ibImgItems     = $ibItems.not('.ib-content'),
                imgItemsCount   = $ibImgItems.length,
                init            = function() {
                    console.log("sup");
                };
            
            return { init : init };
        })();

        Template.init();
});

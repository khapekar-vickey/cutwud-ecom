jQuery(function($){

    window.injectSirvJS = function(){
        let ifr = $('iframe#elementor-preview-iframe')[0];
        //console.log(ifr);
        let scr = ifr.contentWindow.document.createElement('script');
        ifr.contentWindow.document.head.append(scr);
        scr.src = 'http://scripts.sirv.com/sirv.js';
    }


    function startSirvJS(){
        if(!!window.Sirv){
            Sirv.start();
            //$('.elementor-widget-container, .sirv-elementor-click-overlay').on('click', function(){
            $('.sirv-elementor-click-overlay').on('click', function(){
                window.parent.runEvent(window.parent, 'renderShPanel');
            });
        }
    }

    $(document).on('updateSh', startSirvJS);


    $(document).ready(function(){
        //console.log('Run injectSirvJS');
        //injectSirvJS();
        startSirvJS();
        //$('.elementor-widget-container, .sirv-elementor-click-overlay').on('click', function(){
        $('.sirv-elementor-click-overlay').on('click', function(){
            //updateElementorSirvControl('true', true);
            //console.log('RUN edit mode');

            //console.log(window.parent == window.top);

            window.parent.runEvent(window.parent, 'renderShPanel');
        });
    }); // dom ready end

}); //closure end

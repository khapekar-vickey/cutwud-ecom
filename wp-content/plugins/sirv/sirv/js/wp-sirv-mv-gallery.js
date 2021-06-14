//-------------------------gloval MV vars------------------------------
let captions = [];
//---------------------------------------------------------------------

function initializeCaption(id) {
    caps = jQuery.parseJSON(jQuery('#' + id).attr('data-mv-captions'));

    if(!!caps.length){
        captions[id] = caps;

        if (!!jQuery('.sirv-mv-caption.' + id).length) {
            jQuery('.sirv-mv-caption.' + id).html(captions[id][0]);
        }else{
            jQuery('#' + id + ' .smv-slides-box').after('<div class="sirv-mv-caption '+id+'">' + captions[id][0] + '</div>');
        }
    }
}

jQuery(document).ready(function () {
    //------------------------------------Media Viewer-------------------------------------//
    Sirv.on('viewer:ready', function (viewer) {
        initializeCaption(viewer.id);
    });

    Sirv.on('viewer:beforeSlideIn', (slide) => {
        let index = slide.index;
        let id = slide.parent().id;
        if (!!captions[id]){
            jQuery('.sirv-mv-caption.' + id).html(captions[id][index]);
        }
    });
});
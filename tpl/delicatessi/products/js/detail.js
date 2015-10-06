$('a[data-action="enlarge"]').mousedown(function(){
    $('#product-image-large').attr('src', $(this).find('img').attr('src'));
});


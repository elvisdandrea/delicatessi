$(function() {
    $('nav#menu-left').mmenu();
});

$(function() {
    $('#ei-slider').eislideshow({
        animation			: 'center',
        autoplay			: true,
        slideshow_interval	: 3000,
        titlesFactor		: 0
    });
});

$(document).ready(function() {
    $(".scroll").click(function(event){
        event.preventDefault();
        $('html,body').animate({
            scrollTop: $(this.hash).offset().top}, 1200);
    });
});

$(document).on('click','.modal-close', function(){
    $('body').removeClass('dialogIsOpen');
    $('.modal').remove();
});
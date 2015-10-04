var page = 2;
var paginationActive = true;

$(window).unbind('scroll').scroll(function() {

    if ($('#main').attr('url') == undefined) return false;
    if (!paginationActive) return false;

    if ($(window).scrollTop() + $(window).height() == $(document).height()) {
        Html.Get($('#main').attr('url') + '&page=' + page, function(r) {
            if (r != '') {
                eval(r);
                page++;
            }
            return false;
        });
    }
});
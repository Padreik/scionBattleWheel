
$(".admin-icon-holder").click(function() {
    var link = $(this);
    var url = link.data('url');
    $(location).attr('href',url);
});

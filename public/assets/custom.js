$(function () {
    $('[data-toggle="tooltip"]').tooltip();
});

function base_url() {
    // get the segments
    pathArray = window.location.pathname.split("/");
    // find where the segment is located
    return (
        window.location.origin+'/'
    );
}

function imgPath(folder, file) {
    if (!file) return base_url() + "public/no-img.png";
    return base_url() + '/public/'+folder + "/" + file;
}

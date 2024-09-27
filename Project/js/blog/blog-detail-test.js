// Fetch data using AJAX
$(document).ready(function () {
    $.ajax({
        url: '../../controller/Blog/blog-detail-controller.php',
        type: 'GET',
        dataType: 'json',
        data: { blogTitle: getParameterByName('blogTitle') },
        success: function (data) {
            if (data) {
                console.log(data);
                let imageBlog = 'data:BLOG_IMG/png;base64,' + data.BLOG_IMG;
                $('.blog-img img').attr('src', imageBlog);
                $('.blog-title h4').text(data.BLOG_TITLE);
                $('.blog-content p').text(data.CONTENT);
                $('.blog-date p').text(data.BLOG_DAY);
                $('.blog-author p').text(data.USER_NAME);
            }
            else {
                console.error('Empty data received from the server.');
            }
        },
        error: function () {
            console.error('Failed to fetch data from the server.');
        }
    });

    // Lấy tên sản phẩm từ URL
    function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }
});
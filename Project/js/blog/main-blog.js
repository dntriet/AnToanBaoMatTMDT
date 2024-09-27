$(document).ready(function () {
    $.ajax({
        url: '../../controller/Blog/main-blog-controller.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            if (data) {
                data.forEach(function (row) {
                    var words = (row.CONTENT).split(' ').slice(0, 40).join(' ');

                    let imageBlog = 'data:BLOG_IMG/png;base64,' + row.BLOG_IMG;
                    $('.blog').append(`
                        <div class="blog-content zoom-when--hover">
                            <a class="blog-link" href="#">
                                <div class="blog-img--container zoom-img--container">
                                    <img class="blog-img zoom-img" src="${imageBlog}" alt="" />
                                </div>
                                <p class="blog-title">${row.BLOG_TITLE}</p>
                                <p class="preview-content">${words + '...'}</p>
                            </a>
                        </div>
                    `);
                })

                $('.blog-content').click(function () {
                    let blogTitle = $(this).find('.blog-title').text();
                    
                    // Tạo URL mới với tham số truyền vào là tên blog title
                    var url = '../../store/blog-info/blog-detail-test.php?blogTitle=' + encodeURIComponent(blogTitle);

                    // Chuyển hướng đến trang mới
                    window.location.href = url;
                })
            }
            else {
                console.error('Empty data received from the server.');
            }
        },
        error: function () {
            console.error('Failed to fetch data from the server.');
        }
    });
});



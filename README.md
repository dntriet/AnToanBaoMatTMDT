## Cách chạy Web với JWT
* 1. Trong file **connect.php**, nhớ đổi port từ 3307 thành 3306 (hoặc xóa đi nếu port mặc định của mọi người là 3306)

* 2. Tải Composer để download thực viện JWT cho PHP: [Link](https://getcomposer.org/)
     Sau đó vào thư mục **..\Project\php\Controller** của trang web, chuột phải -> Open Git Bash -> gõ lệnh ls để kiểm trả các file trong thư mục này đã có 2 file config là **composer.json và composer.lock** hay chưa, nếu đã có rồi thì gõ lệnh sau đây để cài thư viện JWT.
```
npm instal
```
**Lưu ý:** Nếu có lỗi composer is not recognize gì gì đó thì nhớ add path của composer vào Environment Path của System [Link tham khảo](https://stackoverflow.com/questions/39724594/composer-is-not-recognized-as-an-internal-or-external-command-in-windows-serve)
Để chắc chắn hơn có thể gõ lệnh sau để kiểm trả Composer đã được cài (nhớ tắt Warp hay Xampp để refresh sever nha).
```
composer --version
```
## Sau khi làm sau thì Web đã có bảo mật an toàn bằng JWT, vì chỉ làm ở phần Backend nên có thể demo bằng Postman. Có thể tham khảo trong file word rủi ro t làm nha. 




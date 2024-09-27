<?php session_start();
$user_id = isset($_SESSION['user_id']) ? json_encode($_SESSION['user_id']) : 'null';
echo '<script> var user_id =' . $user_id . ';</script>';
?>
    <link rel="stylesheet" href="../../../css/store/question_page_style.css">
    
    <!-- Start of header -->
    <?php 
        $title = "Hỗ trợ";
        include("../header-footer-nav/header.php"); ?>

    
    <!-- End of header -->
    <h2>HỖ TRỢ</h2>

    <div class="contentBox">
        <div class="contentBox__Left">
            <div class="Content">
                <h4>CÁC CHỌN KÍCH THƯỚC</h4>
                <br>
                <table>
                    <tr>
                        <td>US - Men's</td>
                        <td>3.5</td>
                        <td>4</td>
                        <td>4.5</td>
                        <td>5</td>
                        <td>6</td>
                        <td>6</td>
                        <td>6.5</td>
                        <td>7</td>
                        <td>7.5</td>
                        <td>8</td>
                        <td>8.5</td>
                        <td>9</td>
                        <td>9.5</td>
                        <td>10</td>
                        <td>11</td>
                        <td>11</td>
                        <td>12</td>
                        <td>12</td>
                        <td>13</td>
                    </tr>
                    <tr>
                        <td>US - Women's</td>
                        <td>5</td>
                        <td>6</td>
                        <td>6</td>
                        <td>6.5</td>
                        <td>7</td>
                        <td>7.5</td>
                        <td>8</td>
                        <td>9</td>
                        <td>9</td>
                        <td>10</td>
                        <td>10</td>
                        <td>11</td>
                        <td>11</td>
                        <td>12</td>
                        <td>12</td>
                        <td>13</td>
                        <td>13</td>
                        <td>14</td>
                        <td>14</td>
                    </tr>
                    <tr>
                        <td>UK</td>
                        <td>3</td>
                        <td>4</td>
                        <td>4</td>
                        <td>4.5</td>
                        <td>5</td>
                        <td>5.5</td>
                        <td>6</td>
                        <td>6</td>
                        <td>6.5</td>
                        <td>7</td>
                        <td>7.5</td>
                        <td>8</td>
                        <td>9</td>
                        <td>9.5</td>
                        <td>10</td>
                        <td>10</td>
                        <td>11</td>
                        <td>11</td>
                        <td>12</td>
                    </tr>
                    <tr>
                        <td>EU</td>
                        <td>36</td>
                        <td>36</td>
                        <td>37</td>
                        <td>37</td>
                        <td>38</td>
                        <td>38</td>
                        <td>39</td>
                        <td>39</td>
                        <td>40</td>
                        <td>41</td>
                        <td>41</td>
                        <td>42</td>
                        <td>43</td>
                        <td>43</td>
                        <td>44</td>
                        <td>45</td>
                        <td>46</td>
                        <td>46</td>
                        <td>47</td>
                    </tr>
                </table>
                <br>
                <p>
                    Tuy nhiên, thông số chỉ có thể tham khảo, không đảm bảo rằng hoàn toàn phù hợp với kích thước thực tế.
                </p>
            </div>

            <div class="Related_Questions">
                <p>Các câu hỏi liên quan:</p>
                <ul style="list-style-type:disc">
                    <li><a href="../blog-info/question-page-Bao-hanh.php">Quy định bảo hành.</a></li>
                    <li><a href="../blog-info/question-page-Phuong-thuc-thanh-toan.php">Các phương thức thanh toán.</a></li>
                </ul>
            </div>
        </div>


        <div class="line">
            <svg height="800px" width="2px">
                <line x1="0" y1="0" x2="0" y2="590" style="stroke:black; stroke-width: 3px;" />
            </svg>

            <hr>
        </div>

        <div class="contentBox__Right">
            <div class="centerBox">
                <img src="../../../img/chat.png" alt="">
                <p>EMAIL</p>
                <p>215215xx@gm.uit.edu.vn</p>
            </div>
            <div class="centerBox">
                <img src="../../../img/telephone.png" alt="">
                <p>ĐIỆN THOẠI</p>
                <p>0913567184</p>
            </div>
            <div class="centerBox">
                <img src="../../../img/location.png" alt="">
                <p>ĐỊA CHỈ</p>
                <p>Khu phố 6, P.Linh Trung, Tp.Thủ Đức, Tp.Hồ Chí Minh</p>
            </div>
        </div>
    </div>

    <!-- TODO: hr of footer disappears -->
    <!-- Start of footer -->
        <?php include("../header-footer-nav/footer.php"); ?>
    <!-- End of footer -->
</body>

</html>
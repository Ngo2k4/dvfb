<?php
function sendDS($mail_nhan,$ten_nhan,$chu_de,$noi_dung,$bcc){
        //modify by Duy Sexy
        $mail = new PHPMailer(); // khai báo đối tượng
        $mail->SMTPDebug = 0;                // không debug                 
        $mail->isSMTP();                       // kết nối smtp             
        $mail->Host = 'smtp.gmail.com';   //smtp của gmail
        $mail->SMTPAuth = true;                              // xác minh smtp  
        $mail->Username = 'duysexy98tb@gmail.com';         // user gmail  
        $mail->Password = 'saophaixoan';                      // pass     
        $mail->SMTPSecure = 'tls';                           //giao thức tls
        $mail->Port = 587;                                   // cổng
        $mail->setFrom('duysexy98tb@gmail.com', $bcc); // địa chỉ và tên người gửi
        $mail->addAddress($mail_nhan, $ten_nhan);     // địa chỉ và tên người nhận
        $mail->addReplyTo('duysexy98tb@gmail.com', $bcc); // đìa chỉ và tên khi người nhận trả lời
        $mail->isHTML(true);   // hiển thị nội dung dưới dạn html
        $mail->Subject = "$ten_nhan, $chu_de"; // chủ đề eamil
        $mail->Body    = $noi_dung;
        $mail->CharSet = 'UTF-8';  // set mã hóa unicode
        $send = $mail->send();
        return $send;
    }
?>
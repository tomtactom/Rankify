<?php
function email_template($title, $content) {
    $style = 'body{background:#f5f7fb;font-family:Arial,sans-serif;color:#333;}'
        .' .box{max-width:600px;margin:20px auto;background:#fff;border-radius:8px;'
        .'padding:20px;border:1px solid #e2e2e2;}'
        .' h1{color:#2E5BDA;font-size:1.4em;margin-top:0;}';
    return "<!DOCTYPE html><html><head><meta charset='UTF-8'><style>{$style}</style></head><body><div class='box'><h1>Rankify</h1>".$content."<p style='font-size:12px;color:#666;margin-top:30px;'>Diese Mail wurde automatisch über Rankify erzeugt.</p></div></body></html>";
}

function send_email($to, $subject, $content) {
    global $ADMIN_EMAIL;
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: Rankify <{$ADMIN_EMAIL}>\r\n";
    @mail($to, $subject, email_template($subject, $content), $headers);
}

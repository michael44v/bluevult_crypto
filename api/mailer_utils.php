<?php

function sendEmail($to_email, $to_name, $subject, $message, $link = '#') {
    // Detect the current domain dynamically
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    $url = "$protocol://$host/api/mail.php";

    $data = [
        'email' => $to_email,
        'name' => $to_name,
        'subject' => $subject,
        'message' => $message,
        'link' => $link
    ];

    $options = [
        'http' => [
            'header'  => "Content-Type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($data),
        ],
    ];
    $context  = stream_context_create($options);
    $result = @file_get_contents($url, false, $context);
    return $result;
}

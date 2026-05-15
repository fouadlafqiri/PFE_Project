<?php
$url = "http://127.0.0.1:8000/register";
$data = [
  "name" => "testuser_" . rand(1000,9999),
  "email" => "hichamouaddate+new2_" . rand(1000,9999) . "@gmail.com",
  "password" => "Password123!",
  "password_confirmation" => "Password123!"
];

$options = [
  "http" => [
    "method" => "POST",
    "header" => "Content-Type: application/x-www-form-urlencoded",
    "content" => http_build_query($data),
    "ignore_errors" => true
  ]
];

$context = stream_context_create($options);
$resp = file_get_contents($url, false, $context);

$statusLine = $http_response_header[0] ?? "";
echo $statusLine . PHP_EOL;
echo (string)$resp;

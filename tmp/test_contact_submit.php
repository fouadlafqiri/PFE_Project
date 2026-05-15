<?php
$baseUrl = "http://127.0.0.1:8000";

$contextGet = stream_context_create([
  "http" => [
    "method" => "GET",
    "ignore_errors" => true,
    "timeout" => 10,
  ]
]);

$client = file_get_contents($baseUrl . "/contact", false, $contextGet);
if ($client === false) {
  echo "GET /contact failed\n";
  exit(1);
}

preg_match('/name="_token"\s+value="([^"]+)"/', $client, $m);
$token = $m[1] ?? null;
if (!$token) {
  echo "CSRF token not found\n";
  exit(2);
}

// Collect cookies from the GET response
$cookies = [];
foreach (($http_response_header ?? []) as $h) {
  if (stripos($h, "Set-Cookie:") === 0) {
    // Keep only cookie pair before ';'
    $cookiePair = trim(substr($h, strlen("Set-Cookie:")));
    $cookiePair = explode(";", $cookiePair)[0];
    if ($cookiePair) $cookies[] = $cookiePair;
  }
}
$cookieHeader = implode("; ", $cookies);

$data = [
  "name" => "Hicham OUADDATE",
  "email" => "hichamouaddate_test_" . rand(1000, 9999) . "@gmail.com",
  "phone" => "0660194559",
  "subject" => "sdfsd",
  "message" => "fsdfsd",
  "_token" => $token
];

$body = http_build_query($data);

$contextPost = stream_context_create([
  "http" => [
    "method" => "POST",
    "header" => "Content-Type: application/x-www-form-urlencoded\r\n" . ($cookieHeader ? "Cookie: " . $cookieHeader : ""),
    "content" => $body,
    "ignore_errors" => true,
    "timeout" => 10,
  ]
]);

$resp = file_get_contents($baseUrl . "/contact", false, $contextPost);

$headers = $http_response_header ?? [];
echo "STATUS: " . ($headers[0] ?? "NO_STATUS") . "\n";
echo "RESP_START\n";
echo substr((string)$resp, 0, 300) . "\n";
echo "RESP_END\n";
?>

<?php
$baseUrl = "http://127.0.0.1:8000";

// 1) GET a page that renders CSRF token in HTML
$getUrl = $baseUrl . "/products/1";
$page = file_get_contents($getUrl, false, stream_context_create([
  "http" => [
    "method" => "GET",
    "ignore_errors" => true,
    "timeout" => 10,
  ]
]));

if ($page === false) {
  echo "GET page failed\n";
  exit(1);
}

// 2) Extract CSRF token
preg_match('/name="_token"\s+value="([^"]+)"/', $page, $m);
$token = $m[1] ?? null;
if (!$token) {
  echo "CSRF token not found\n";
  exit(2);
}

// 3) Collect cookies from the GET response headers
$cookies = [];
foreach (($http_response_header ?? []) as $h) {
  if (stripos($h, "Set-Cookie:") === 0) {
    $cookiePair = trim(substr($h, strlen("Set-Cookie:")));
    $cookiePair = explode(";", $cookiePair)[0];
    if ($cookiePair) $cookies[] = $cookiePair;
  }
}
$cookieHeader = implode("; ", $cookies);

// 4) POST /cart/add/1 with token+cookies
$postUrl = $baseUrl . "/cart/add/1";
$data = [
  "_token" => $token,
];

$body = http_build_query($data);

$context = stream_context_create([
  "http" => [
    "method" => "POST",
    "header" => "Content-Type: application/x-www-form-urlencoded\r\n" .
                 ($cookieHeader ? "Cookie: " . $cookieHeader : ""),
    "content" => $body,
    "ignore_errors" => true,
    "timeout" => 10,
  ]
]);

$resp = file_get_contents($postUrl, false, $context);
$headers = $http_response_header ?? [];

echo "STATUS_LINE: " . ($headers[0] ?? "NO_STATUS") . "\n";
echo "RESP_START\n";
echo substr((string)$resp, 0, 300) . "\n";
echo "RESP_END\n";
?>

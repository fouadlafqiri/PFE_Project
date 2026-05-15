<?php
$url = "http://127.0.0.1:8000/news";

$context = stream_context_create([
  "http" => [
    "method" => "GET",
    "ignore_errors" => true,
    "timeout" => 10,
  ],
]);

$resp = file_get_contents($url, false, $context);

$headers = $http_response_header ?? [];
echo "STATUS_LINE: " . ($headers[0] ?? "NO_STATUS") . "\n";
echo "RESP_START\n";
echo substr((string)$resp, 0, 500) . "\n";
echo "RESP_END\n";
?>

<?php
$url = "http://127.0.0.1:8000/admin/deliveries";

$context = stream_context_create([
  "http" => [
    "method" => "GET",
    "ignore_errors" => true,
    "timeout" => 10,
  ],
]);

$resp = file_get_contents($url, false, $context);
echo "RESPONSE_START\n";
echo substr((string)$resp, 0, 500) . "\n";
echo "RESPONSE_END\n";

$headers = $http_response_header ?? [];
if (!empty($headers)) {
  echo "STATUS_LINE: " . ($headers[0] ?? "") . "\n";
}
?>

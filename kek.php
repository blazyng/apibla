<?php
$username = 'username';
$password = 'password';
// Basic authentication to prevent unauthorized requests
if (($_SERVER['PHP_AUTH_USER'] ?? null) !== $username ||
($_SERVER['PHP_AUTH_PW'] ?? null) !== $password) {
header('WWW-Authenticate: Basic realm="Leads"');
header('HTTP/1.1 401 Unauthorized');
die();
}
function decodeParameter(string $parameterName, bool $isBase64Encoded = false): ?string {
if (!isset($_GET[$parameterName])) {
return null;
}
$decoded = urldecode($_GET[$parameterName]);
if ($isBase64Encoded) {
return base64_decode($decoded);
}
return $decoded;
}
$data = [
'salutation' => decodeParameter('salutation'),
'firstName' => decodeParameter('firstname'),
'lastName' => decodeParameter('lastname'),
'email' => decodeParameter('email'),
'sovId' => decodeParameter('sov_id'),
'complianceIp' => decodeParameter('complianceip'),
'complianceText' => decodeParameter('compliancetext', true),
'complianceTimestamp' => decodeParameter('compliancetimestamp', true),
];
file_put_contents('output.json', json_encode($data) . "\n", FILE_APPEND | LOCK_EX);

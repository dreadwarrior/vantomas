<?php
$extensionPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('vantomas');

return array(
	'Net_Http' => $extensionPath . 'vendor/net/http/src/Net/Http.php',
	'Net_Http_Client' => $extensionPath . 'vendor/net/http/src/Net/Http/Client.php',
	'Net_Http_ClientError' => $extensionPath . 'vendor/net/http/src/Net/Http/ClientError.php',
	'Net_Http_Exception' => $extensionPath . 'vendor/net/http/src/Net/Http/Exception.php',
	'Net_Http_NetworkError' => $extensionPath . 'vendor/net/http/src/Net/Http/NetworkError.php',
	'Net_Http_ProtocolError' => $extensionPath . 'vendor/net/http/src/Net/Http/ProtocolError.php',
	'Net_Http_Request' => $extensionPath . 'vendor/net/http/src/Net/Http/Request.php',
	'Net_Http_Response' => $extensionPath . 'vendor/net/http/src/Net/Http/Response.php',
	'Net_Http_ServerError' => $extensionPath . 'vendor/net/http/src/Net/Http/ServerError.php',
);
?>
<?php
/**
 * ROAMIE - Midtrans SDK Installer
 * Writes all Midtrans PHP files directly to the server.
 * DELETE THIS FILE AFTER USE!
 */

$basePath = dirname(__DIR__); // /home/zytraxoc/public_html/roamie-rentcar
$midtransRoot = $basePath . '/vendor/midtrans';
$sdkPath = $midtransRoot . '/midtrans-php';
$classPath = $sdkPath . '/Midtrans';

$log = [];
$errors = [];

function makeDir($path, &$log, &$errors) {
    if (!is_dir($path)) {
        if (mkdir($path, 0755, true)) {
            $log[] = "✅ Created dir: $path";
        } else {
            // Try chmod parent first
            chmod(dirname($path), 0755);
            if (mkdir($path, 0755, true)) {
                $log[] = "✅ Created dir (after chmod): $path";
            } else {
                $errors[] = "❌ Failed mkdir: $path";
            }
        }
    } else {
        chmod($path, 0755);
        $log[] = "📁 Dir exists (chmod 755): $path";
    }
}

function writeFile($path, $content, &$log, &$errors) {
    // Ensure parent dir is writable
    $dir = dirname($path);
    if (is_dir($dir)) {
        chmod($dir, 0755);
    }
    if (file_put_contents($path, $content) !== false) {
        chmod($path, 0644);
        $log[] = "✅ Written: " . basename($path);
    } else {
        $errors[] = "❌ Failed to write: $path";
    }
}

// Step 1: Fix / create directories
makeDir($midtransRoot, $log, $errors);
makeDir($sdkPath, $log, $errors);
makeDir($classPath, $log, $errors);

// Step 2: Write all PHP files inline

// --- Midtrans.php ---
writeFile($sdkPath . '/Midtrans.php', '<?php
if (version_compare(PHP_VERSION, \'5.4\', \'<\')) {
    throw new Exception(\'PHP version >= 5.4 required\');
}
if (!function_exists(\'curl_init\') || !function_exists(\'curl_exec\')) {
    throw new Exception(\'Midtrans needs the CURL PHP extension.\');
}
if (!function_exists(\'json_decode\')) {
    throw new Exception(\'Midtrans needs the JSON PHP extension.\');
}
require_once \'Midtrans/Config.php\';
require_once \'Midtrans/Transaction.php\';
require_once \'Midtrans/ApiRequestor.php\';
require_once \'Midtrans/Notification.php\';
require_once \'Midtrans/CoreApi.php\';
require_once \'Midtrans/Snap.php\';
require_once \'Midtrans/Sanitizer.php\';
require_once \'Midtrans/SnapApiRequestor.php\';
', $log, $errors);

// --- Config.php ---
writeFile($classPath . '/Config.php', '<?php
namespace Midtrans;
class Config {
    public static $serverKey;
    public static $clientKey;
    public static $isProduction = false;
    public static $is3ds = false;
    public static $appendNotifUrl;
    public static $overrideNotifUrl;
    public static $paymentIdempotencyKey;
    public static $isSanitized = false;
    public static $curlOptions = array();
    const SANDBOX_BASE_URL = \'https://api.sandbox.midtrans.com\';
    const PRODUCTION_BASE_URL = \'https://api.midtrans.com\';
    const SNAP_SANDBOX_BASE_URL = \'https://app.sandbox.midtrans.com/snap/v1\';
    const SNAP_PRODUCTION_BASE_URL = \'https://app.midtrans.com/snap/v1\';
    public static function getBaseUrl() {
        return Config::$isProduction ? Config::PRODUCTION_BASE_URL : Config::SANDBOX_BASE_URL;
    }
    public static function getSnapBaseUrl() {
        return Config::$isProduction ? Config::SNAP_PRODUCTION_BASE_URL : Config::SNAP_SANDBOX_BASE_URL;
    }
}
', $log, $errors);

// --- ApiRequestor.php ---
writeFile($classPath . '/ApiRequestor.php', '<?php
namespace Midtrans;
use Exception;
class ApiRequestor {
    public static function get($url, $server_key, $data_hash) {
        return self::remoteCall($url, $server_key, $data_hash, \'GET\');
    }
    public static function post($url, $server_key, $data_hash) {
        return self::remoteCall($url, $server_key, $data_hash, \'POST\');
    }
    public static function patch($url, $server_key, $data_hash) {
        return self::remoteCall($url, $server_key, $data_hash, \'PATCH\');
    }
    public static function remoteCall($url, $server_key, $data_hash, $method) {
        $ch = curl_init();
        if (!$server_key) {
            throw new Exception(\'Midtrans server key is not set. Check Config.\');
        }
        $curl_options = array(
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => array(
                \'Content-Type: application/json\',
                \'Accept: application/json\',
                \'User-Agent: midtrans-php-v2.6.2\',
                \'Authorization: Basic \' . base64_encode($server_key . \':\')
            ),
            CURLOPT_RETURNTRANSFER => 1
        );
        if (Config::$appendNotifUrl) Config::$curlOptions[CURLOPT_HTTPHEADER][] = \'X-Append-Notification: \' . Config::$appendNotifUrl;
        if (Config::$overrideNotifUrl) Config::$curlOptions[CURLOPT_HTTPHEADER][] = \'X-Override-Notification: \' . Config::$overrideNotifUrl;
        if (Config::$paymentIdempotencyKey) Config::$curlOptions[CURLOPT_HTTPHEADER][] = \'Idempotency-Key: \' . Config::$paymentIdempotencyKey;
        if (count(Config::$curlOptions)) {
            if (isset(Config::$curlOptions[CURLOPT_HTTPHEADER])) {
                $mergedHeaders = array_merge($curl_options[CURLOPT_HTTPHEADER], Config::$curlOptions[CURLOPT_HTTPHEADER]);
                $headerOptions = array(CURLOPT_HTTPHEADER => $mergedHeaders);
            } else {
                $headerOptions = array();
            }
            $curl_options = array_replace_recursive($curl_options, Config::$curlOptions, $headerOptions);
        }
        if ($method != \'GET\') {
            if ($data_hash) {
                $curl_options[CURLOPT_POSTFIELDS] = json_encode($data_hash);
            } else {
                $curl_options[CURLOPT_POSTFIELDS] = \'\';
            }
            if ($method == \'POST\') {
                $curl_options[CURLOPT_POST] = 1;
            } elseif ($method == \'PATCH\') {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, \'PATCH\');
            }
        }
        curl_setopt_array($ch, $curl_options);
        $result = curl_exec($ch);
        if ($result === false) {
            throw new Exception(\'CURL Error: \' . curl_error($ch), curl_errno($ch));
        }
        $result_array = json_decode($result);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (isset($result_array->status_code) && $result_array->status_code >= 401 && $result_array->status_code != 407) {
            throw new Exception(\'Midtrans API error. HTTP: \' . $result_array->status_code . \' Response: \' . $result, $result_array->status_code);
        } elseif ($httpCode >= 400) {
            throw new Exception(\'Midtrans API error. HTTP: \' . $httpCode . \' Response: \' . $result, $httpCode);
        }
        return $result_array;
    }
}
', $log, $errors);

// --- Transaction.php ---
writeFile($classPath . '/Transaction.php', '<?php
namespace Midtrans;
use Exception;
class Transaction {
    public static function status($id) {
        return ApiRequestor::get(Config::getBaseUrl() . \'/v2/\' . $id . \'/status\', Config::$serverKey, false);
    }
    public static function approve($id) {
        return ApiRequestor::post(Config::getBaseUrl() . \'/v2/\' . $id . \'/approve\', Config::$serverKey, false)->status_code;
    }
    public static function cancel($id) {
        return ApiRequestor::post(Config::getBaseUrl() . \'/v2/\' . $id . \'/cancel\', Config::$serverKey, false)->status_code;
    }
    public static function expire($id) {
        return ApiRequestor::post(Config::getBaseUrl() . \'/v2/\' . $id . \'/expire\', Config::$serverKey, false);
    }
    public static function refund($id, $params) {
        return ApiRequestor::post(Config::getBaseUrl() . \'/v2/\' . $id . \'/refund\', Config::$serverKey, $params);
    }
    public static function deny($id) {
        return ApiRequestor::post(Config::getBaseUrl() . \'/v2/\' . $id . \'/deny\', Config::$serverKey, false);
    }
}
', $log, $errors);

// --- Notification.php ---
writeFile($classPath . '/Notification.php', '<?php
namespace Midtrans;
class Notification {
    private $response;
    public function __construct($input_source = "php://input") {
        $raw_notification = json_decode(file_get_contents($input_source), true);
        $status_response = Transaction::status($raw_notification[\'transaction_id\']);
        $this->response = $status_response;
    }
    public function __get($name) {
        if (isset($this->response->$name)) { return $this->response->$name; }
    }
    public function getResponse() { return $this->response; }
}
', $log, $errors);

// --- Snap.php ---
writeFile($classPath . '/Snap.php', '<?php
namespace Midtrans;
use Exception;
class Snap {
    public static function getSnapToken($params) {
        return (Snap::createTransaction($params)->token);
    }
    public static function getSnapUrl($params) {
        return (Snap::createTransaction($params)->redirect_url);
    }
    public static function createTransaction($params) {
        $payloads = array(\'credit_card\' => array(\'secure\' => Config::$is3ds));
        if (isset($params[\'item_details\'])) {
            $gross_amount = 0;
            foreach ($params[\'item_details\'] as $item) {
                $gross_amount += $item[\'quantity\'] * $item[\'price\'];
            }
            $params[\'transaction_details\'][\'gross_amount\'] = $gross_amount;
        }
        if (Config::$isSanitized) { Sanitizer::jsonRequest($params); }
        $params = array_replace_recursive($payloads, $params);
        return ApiRequestor::post(Config::getSnapBaseUrl() . \'/transactions\', Config::$serverKey, $params);
    }
}
', $log, $errors);

// --- CoreApi.php ---
writeFile($classPath . '/CoreApi.php', '<?php
namespace Midtrans;
use Exception;
class CoreApi {
    public static function charge($params) {
        return ApiRequestor::post(Config::getBaseUrl() . \'/v2/charge\', Config::$serverKey, $params);
    }
    public static function cardToken($params) {
        $params[\'client_key\'] = Config::$clientKey;
        return ApiRequestor::get(Config::getBaseUrl() . \'/v2/token\', Config::$serverKey, $params);
    }
    public static function cardRegister($params) {
        $params[\'client_key\'] = Config::$clientKey;
        return ApiRequestor::get(Config::getBaseUrl() . \'/v2/card/register\', Config::$serverKey, $params);
    }
    public static function linkPaymentAccount($params) {
        return ApiRequestor::post(Config::getBaseUrl() . \'/v2/pay/account\', Config::$serverKey, $params);
    }
    public static function getPaymentAccount($accountId) {
        return ApiRequestor::get(Config::getBaseUrl() . \'/v2/pay/account/\' . $accountId, Config::$serverKey, null);
    }
    public static function unlinkPaymentAccount($accountId) {
        return ApiRequestor::post(Config::getBaseUrl() . \'/v2/pay/account/\' . $accountId . \'/unbind\', Config::$serverKey, null);
    }
}
', $log, $errors);

// --- Sanitizer.php ---
writeFile($classPath . '/Sanitizer.php', '<?php
namespace Midtrans;
class Sanitizer {
    private $filters;
    public function __construct() { $this->filters = array(); }
    public static function jsonRequest(&$json) {
        $keys = array(\'item_details\', \'customer_details\');
        foreach ($keys as $key) {
            if (!isset($json[$key])) continue;
            $camel = static::upperCamelize($key);
            $function = "field$camel";
            static::$function($json[$key]);
        }
    }
    private static function fieldItemDetails(&$items) {
        foreach ($items as &$item) {
            $id = new self; $item[\'id\'] = $id->maxLength(50)->apply($item[\'id\']);
            $name = new self; $item[\'name\'] = $name->maxLength(50)->apply($item[\'name\']);
        }
    }
    private static function fieldCustomerDetails(&$field) {
        foreach ([\'first_name\', \'last_name\', \'email\', \'phone\'] as $k) {
            if (isset($field[$k])) { $s = new self; $field[$k] = $s->maxLength(255)->apply($field[$k]); }
        }
    }
    private function maxLength($length) {
        $this->filters[] = function ($input) use ($length) { return substr($input, 0, $length); };
        return $this;
    }
    private function whitelist($regex) {
        $this->filters[] = function ($input) use ($regex) { return preg_replace("/[^$regex]/", \'\', $input); };
        return $this;
    }
    private function apply($input) {
        foreach ($this->filters as $filter) { $input = call_user_func($filter, $input); }
        return $input;
    }
    private static function upperCamelize($string) {
        return str_replace(\' \', \'\', ucwords(str_replace(\'_\', \' \', $string)));
    }
}
', $log, $errors);

// --- SnapApiRequestor.php ---
writeFile($classPath . '/SnapApiRequestor.php', '<?php
namespace Midtrans;
class SnapApiRequestor {
    public static function get($url, $server_key, $data_hash) { return self::remoteCall($url, $server_key, $data_hash, false); }
    public static function post($url, $server_key, $data_hash) { return self::remoteCall($url, $server_key, $data_hash, true); }
    public static function remoteCall($url, $server_key, $data_hash, $post = true) {
        $ch = curl_init();
        $curl_options = array(
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => array(\'Content-Type: application/json\', \'Accept: application/json\', \'Authorization: Basic \' . base64_encode($server_key . \':\')),
            CURLOPT_RETURNTRANSFER => 1
        );
        if ($post) {
            $curl_options[CURLOPT_POST] = 1;
            $curl_options[CURLOPT_POSTFIELDS] = $data_hash ? json_encode($data_hash) : \'\';
        }
        curl_setopt_array($ch, $curl_options);
        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        if ($result === false) throw new \Exception(\'CURL Error: \' . curl_error($ch), curl_errno($ch));
        $result_array = json_decode($result);
        if ($info[\'http_code\'] != 201) throw new \Exception(\'Midtrans Error (\' . $info[\'http_code\'] . \'): \' . $result, $info[\'http_code\']);
        return $result_array;
    }
}
', $log, $errors);

// Step 3: Also clear Blade view cache
$viewCache = $basePath . '/storage/framework/views';
$cleared = 0;
if (is_dir($viewCache)) {
    foreach (glob($viewCache . '/*.php') as $f) {
        if (unlink($f)) $cleared++;
    }
}
$log[] = "🗑️ Blade cache cleared: $cleared views";

// Step 4: Verify files exist
$required = [
    $sdkPath . '/Midtrans.php',
    $classPath . '/Config.php',
    $classPath . '/Snap.php',
    $classPath . '/ApiRequestor.php',
    $classPath . '/Transaction.php',
    $classPath . '/Notification.php',
    $classPath . '/CoreApi.php',
    $classPath . '/Sanitizer.php',
    $classPath . '/SnapApiRequestor.php',
];

$verified = 0;
foreach ($required as $f) {
    if (file_exists($f) && is_readable($f)) {
        $verified++;
    } else {
        $errors[] = "⚠️ NOT readable: $f";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>ROAMIE - Midtrans Installer</title>
<style>
  body { font-family: monospace; background: #0f0f1a; color: #cdd6f4; padding: 2rem; max-width: 900px; margin: auto; }
  h1 { color: #cba6f7; }
  .item { padding: 0.25rem 0.5rem; margin: 0.2rem 0; border-radius: 4px; background: #1e1e2e; font-size: .9rem; }
  .err { background: #3b1515; color: #f38ba8; }
  .done { background: #1a3b2a; color: #a6e3a1; padding: 1.2rem 1.5rem; border-radius: 10px; margin: 1.5rem 0; font-size: 1.1rem; border-left: 4px solid #a6e3a1; }
  .fail { background: #3b1515; padding: 1.2rem 1.5rem; border-radius: 10px; border-left: 4px solid #f38ba8; }
  .warn { background: #2d2a1e; color: #f9e2af; padding: 1rem 1.5rem; margin-top: 1.5rem; border-radius: 8px; border-left: 4px solid #f9e2af; }
  a { color: #89dceb; }
</style>
</head>
<body>
<h1>⚙️ Midtrans SDK Installer</h1>
<p>Installing Midtrans PHP SDK files directly to server...</p>

<h3>Log:</h3>
<?php foreach ($log as $l): ?>
<div class="item"><?= htmlspecialchars($l) ?></div>
<?php endforeach; ?>

<?php if (!empty($errors)): ?>
<h3>Errors:</h3>
<?php foreach ($errors as $e): ?>
<div class="item err"><?= htmlspecialchars($e) ?></div>
<?php endforeach; ?>
<?php endif; ?>

<h3>Verification: <?= $verified ?>/<?= count($required) ?> files OK</h3>

<?php if ($verified === count($required) && empty($errors)): ?>
<div class="done">
  ✅ <strong>Midtrans SDK berhasil diinstall!</strong><br><br>
  <?= $verified ?> file PHP berhasil ditulis dan dapat dibaca.<br><br>
  <a href="https://roamie.zytraxo.com/catalog">→ Coba booking mobil sekarang</a>
</div>
<?php else: ?>
<div class="fail">
  ❌ Instalasi tidak lengkap. Lihat error di atas.
</div>
<?php endif; ?>

<div class="warn">
  ⚠️ <strong>PENTING:</strong> Hapus file ini setelah selesai!<br>
  <code>/public_html/roamie-rentcar/public/install-midtrans.php</code>
</div>
</body>
</html>

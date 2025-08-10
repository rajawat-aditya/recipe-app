<?php 
require_once __DIR__ . '/../../vendor/autoload.php';
// Load .env
// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
// $dotenv->load();

$_ENV['Google_Client_ID'] = getenv('GOOGLE_CLIENT_ID');
$_ENV['Google_Client_Secret'] = getenv('GOOGLE_CLIENT_SECRET');


function base64_encode_html_image($img_file, $cache = false, $ext = null)
{
    if (!is_file($img_file)) {
        return false;
    }

    // Validate that it's actually an image
    $image_info = getimagesize($img_file);
    if ($image_info === false) {
        return false; // Not a valid image
    }

    $b64_file = "{$img_file}.b64";
    if ($cache && is_file($b64_file)) {
        $b64 = file_get_contents($b64_file);
        if ($b64 === false) {
            return false;
        }
    } else {
        $bin = file_get_contents($img_file);
        if ($bin === false) {
            return false;
        }
        
        $b64 = base64_encode($bin);

        if ($cache) {
            if (file_put_contents($b64_file, $b64) === false) {
                // Cache write failed, but continue
            }
        }
    }

    if (!$ext) {
        // Use MIME type from getimagesize for better accuracy
        $mime_type = $image_info['mime'];
        $ext = str_replace('image/', '', $mime_type);
    }

    return "data:image/{$ext};base64,{$b64}";
}


// Function to download and cache Google profile picture
function download_and_cache_profile_picture($picture_url, $user_id) {
    if (empty($picture_url)) {
        return false;
    }
    
    $cache_dir = __DIR__ . '/../cache/profile_pictures/';
    if (!is_dir($cache_dir)) {
        mkdir($cache_dir, 0755, true);
    }
    
    $file_extension = 'jpg'; // Google usually provides JPG
    $local_file = $cache_dir . $user_id . '.' . $file_extension;
    
    // Download the image
    $image_data = file_get_contents($picture_url);
    if ($image_data !== false) {
        file_put_contents($local_file, $image_data);
        return base64_encode_html_image($local_file);
    }
    
    return $picture_url; // Fallback to URL if download fails
}


$client = new Google\Client;
$client->setClientId($_ENV['Google_Client_ID']);
$client->setClientSecret($_ENV['Google_Client_Secret']);
$client->setRedirectUri('https://recipe-app-two-sable.vercel.app/index.php/ap/verify');
$client->addScope("email");
$client->addScope("profile");

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);
    $oauth2 = new Google\Service\Oauth2($client);
    $userInfo = $oauth2->userinfo->get();
    // Handle user information (e.g., store in session)
    $_SESSION['user'] = [
        'id' => $userInfo->id,
        'name' => $userInfo->name,
        'surname' => $userInfo->family_name,
        'email' => $userInfo->email,
        'picture' => download_and_cache_profile_picture($userInfo->picture, $userInfo->id),
    ];
    header('Location: /index.php');
}
?>

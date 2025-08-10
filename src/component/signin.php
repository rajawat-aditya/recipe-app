<?php 
if(!isset($_SESSION)) {
    session_start();
}

$currentUri = $_SERVER['REQUEST_URI'];
$isLoginPage = strpos($currentUri, '/index.php/ap/signin') !== false;

if (!isset($_SESSION['user']) && !$isLoginPage) {
    header('Location: /index.php/ap/signin');
    exit();
}

require_once __DIR__ . '/../../vendor/autoload.php';

// Load .env
// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
// $dotenv->load();

$_ENV['Google_Client_ID'] = getenv('GOOGLE_CLIENT_ID');
$_ENV['Google_Client_Secret'] = getenv('GOOGLE_CLIENT_SECRET');

$client = new Google\Client;
$client->setClientId($_ENV['Google_Client_ID']);
$client->setClientSecret($_ENV['Google_Client_Secret']);
$client->setRedirectUri('https://recipe-app-two-sable.vercel.app/index.php/ap/verify');
$client->addScope("email");
$client->addScope("profile");

$url = $client->createAuthUrl();

?>

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100 p-4 font-sans">
    <div class="w-full max-w-md bg-white rounded-lg shadow-lg border border-gray-200">
        <!-- Header -->
        <div class="text-center space-y-2 pt-8 px-8">
            <h1 class="text-2xl font-bold text-gray-900">Welcome back to Kith</h1>
            <p class="text-gray-600">Sign in to your account to continue</p>
        </div>

        <!-- Content -->
        <div class="p-8 space-y-6">
            <!-- Google Sign In Button -->
            <button 
                id="googleSignIn"
                class="w-full h-12 flex items-center justify-center border border-gray-300 rounded-md bg-white hover:bg-gray-50 transition-colors duration-200 text-base font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
            >
                <!-- Google Logo SVG -->
                <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24">
                    <path
                        fill="#4285F4"
                        d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                    />
                    <path
                        fill="#34A853"
                        d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                    />
                    <path
                        fill="#FBBC05"
                        d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"
                    />
                    <path
                        fill="#EA4335"
                        d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                    />
                </svg>
                <span id="buttonText">Continue with Google</span>
            </button>

            <!-- Loading State (Hidden by default) -->
            <button 
                id="loadingButton"
                class="w-full h-12 flex items-center justify-center border border-gray-300 rounded-md bg-gray-50 text-base font-medium text-gray-500 cursor-not-allowed hidden"
                disabled
            >
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Signing in...
            </button>

            <!-- Terms and Privacy -->
            <div class="text-center">
                <p class="text-sm text-gray-500">
                    By continuing, you agree to our
                    <a href="#" class="text-blue-600 hover:underline">Terms of Service</a>
                    and
                    <a href="#" class="text-blue-600 hover:underline">Privacy Policy</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('googleSignIn').addEventListener('click', function() {
            document.getElementById('googleSignIn').classList.add('hidden');
            document.getElementById('loadingButton').classList.remove('hidden');

            setTimeout(() => {
                document.getElementById('googleSignIn').classList.remove('hidden');
                document.getElementById('loadingButton').classList.add('hidden');
            }, 2000);

            window.location.href = "<?php echo $url; ?>";
        });
    </script>
</div>
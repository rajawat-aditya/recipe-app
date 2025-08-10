<?php
if($_SERVER['HTTP_X_BEARER_TOKEN'] !== 'Ansh by Slew') {
    http_response_code(403);
    echo "Forbidden";
    exit;
}

require_once '../vendor/autoload.php';

// Load .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$token = $_ENV['HF_TOKEN'] ?? die('Token missing');

// Set headers for SSE-like streaming
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('X-Accel-Buffering: no'); // For nginx to disable buffering

flush(); // Force headers to be sent
$chatHistory = $_POST['chat_history'] ?? '' ;

// sent
// API URL
$url = 'https://router.huggingface.co/v1/chat/completions';

// Data payload
$data = [
    "messages" => [
        [
            "role" => "system",
            "content" => "
                    You are a chat title generator for a Kith Ai app which is a cooking assistant.
                    I will give you the conversation history between a user and an assistant.
                    below is the conversation history in json format. if there's only hi or hello in the chat history then return 'New Chat' as title.
                    Your job is to:
                    - Read the entire conversation.
                    - Identify the main topic or purpose.
                    - Output a short, catchy, and descriptive title in 3 to 6 words.
                    - Use title case (Capitalize Major Words).
                    - Do not include punctuation unless necessary.
                    - Do not include the words 'chat', 'conversation', 'discussion', or 'dialogue'.
                    - Output only the title, nothing else.
                    - if the chat history contains one more topics then pick last topic from the chat history.
                    chat history: " . json_encode($chatHistory) . "              
            "
        ]
    ],
    "model" => "openai/gpt-oss-120b:cerebras",
    "stream" => true
];

// Initialize cURL
$ch = curl_init($url);

// Set cURL options
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $token",
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Stream output directly as it arrives
curl_setopt($ch, CURLOPT_WRITEFUNCTION, function ($ch, $chunk) {
    echo $chunk;
    ob_flush();
    flush();
    return strlen($chunk);
});

// Execute the request
curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
}

curl_close($ch);
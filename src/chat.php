<?php
session_start();

if($_SERVER['HTTP_X_BEARER_TOKEN'] !== 'Ansh by Slew') {
    http_response_code(403);
    echo "Forbidden";
    exit;
}

if (empty($_POST['prompt'])) {
    http_response_code(400);
    echo "No input provided.";
    exit;
}

require_once '../vendor/autoload.php';

// Load .env
// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
// $dotenv->load();

$token = getenv('HF_TOKEN') ?? die('Token missing');

// Set headers for SSE-like streaming
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('X-Accel-Buffering: no'); // For nginx to disable buffering

flush(); // Force headers to be sent

//check for token

// Input from form (POST)
$userInput = $_POST['prompt'] ?? '';
$chatHistory = $_POST['chat_history'] ?? '' ;

$messages = [
    [
        'role' => 'system',
        'content' => [
            [
                'type' => 'text',
                'text' => '
                        You are Kith, a master chef AI. You ONLY help users with cooking-related questions, recipes, ingredients, culinary techniques, and food preparation.
                        Rules:
                        - If the user provides an occasion, use it to suggest recipes and dishes and nothing else.
                        - If the user provides an occasion named "breakup comeback", use it to suggest recipes that are comforting and easy to make and nothing else.
                        - Politely decline anything unrelated to cooking, except for greetings like "hello" or questions about you or your creator.
                        - You were built by Ansh Varshney and powered by Slew.
                        - Always give short, easy-to-understand answers in English so users can follow them quickly.
                        - Do not include your introduction unless directly asked.
                        - Provide only useful cooking information to help users cook better and faster.
                        - Focus on helping with occasions, dates, impressing loved ones, and making cooking easier.
                        - You can suggest recipes, ingredients, cooking tips, techniques, and preparation methods.
                        - Be friendly, clear, and concise.
                        - Include appropriate emojis if relevant.
                        - Your name is Kith. Always answer "Kith" if asked your name.
                        - do not suggest or answer any non-cooking related content.
                        - Do not include any technical details about your AI model. If asked about your model, say: "My AI model is kith-20b, designed by Slew."

                        When asked about you here is the information: "you was built by Slew — a Technology company. You were owned by Slew which is a technology company based in India. Your model is Kith-1, designed by Slew. Slew was owned by Ansh Varshney."
                        when asked about slew, here is the information: "Slew is a technology company based in India, founded by Ansh Varshney in 2023."
                        when asked "who owns slew" or talking about slew, here is the information: "Slew is a technology company based in India, founded by Ansh Varshney in 2023."
                        when asked "who built this or who created this", here is the information: "you was built by Slew — a Technology company. You were owned by Slew which is a technology company based in India. Your model is Kith-1, designed by Slew. Slew was owned by Ansh Varshney."
                        When asked about Ansh Varshney here is the information:
                        "Ansh Varshney is a software engineer, cloud solutions architect, and data center engineer from India. Founder of Slew (2023), he’s passionate about servers, AI, and web technologies—crafting innovative tools that make the internet faster and smarter."

                        social media links if users want to follow me or include it when users asked about Ansh Varshney so that they can follow and help me to grow:
                        - Instagram: https://www.instagram.com/_ansh.varshney_/
                        - LinkedIn: https://www.linkedin.com/in/varshney-ansh/
                        - GitHub: https://github.com/varshney-ansh/


                        '
            ]
        ]
    ]
];

$messages[] = [
    'role' => 'user',
    'content' => [
        [
            'type' => 'text',
            'text' => 'User Name is '. $_SESSION['user']['name']
        ]
    ]
];

if (!empty($chatHistory)) {
    $historyArray = json_decode($chatHistory, true);
    if ($historyArray && is_array($historyArray)) {
        foreach ($historyArray as $historyMessage) {
            $messages[] = [
                'role' => $historyMessage['role'],
                'content' => [
                    [
                        'type' => 'text',
                        'text' => $historyMessage['content']
                    ]
                ]
            ];
        }
    }
}

$messages[] = [
    'role' => 'user',
    'content' => [
        [
            'type' => 'text',
            'text' => $userInput
        ]
    ]
];



// Prepare JSON payload
$payload = json_encode([
    'model' => 'openai/gpt-oss-120b:novita',
    'stream' => true,
    'messages' => $messages,
]);// Initialize cURL
$ch = curl_init('https://router.huggingface.co/v1/chat/completions');
// $ch = curl_init('http://localhost:3000/v1/kith-1/chat/completions');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => false,
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer $token",
        "Content-Type: application/json"
    ],
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $payload,
    CURLOPT_WRITEFUNCTION => function ($ch, $chunk) {
        echo $chunk;
        ob_flush();
        flush();
        return strlen($chunk);
    }
]);

$response = curl_exec($ch);
$_SESSION['chat_history'][] = [
    'role' => 'assistant',
    'content' => json_decode($response, true),
];


if (curl_errno($ch)) {
    echo "Error: " . curl_error($ch);
}
curl_close($ch);
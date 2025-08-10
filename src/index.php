<?php 
session_start();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$publicPaths = [
    '/index.php/ap/signin',
    '/index.php/ap/verify',
    '/index.php/ap/logout'
];


switch ($uri) {
    case '/index.php/ap/signin':
        $title = 'Sign In - Kith';
        break;
    case '/index.php/ap/verify':
        $title = 'Verify Account - Kith';
        break;
    case '/index.php/ap/logout':
        $title = 'Logging Out - Kith';
        break;
    case '/index.php/settings':
        $title = 'Settings - Kith';
        break;
    case '/index.php/activities':
        $title = 'Activities - Kith';
        break;
    default:
        $title = 'Kith';
        break;
}


// If user not logged in AND not on a public page → redirect
if (!isset($_SESSION['user']) && !in_array($uri, $publicPaths)) {
    header('Location: /index.php/ap/signin');
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include __DIR__. './component/head.php'; echo $title = Head::render($title . ' | Powered by Slew'); ?>
</head>



<body class="h-screen ">
    <?php if(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) == '/index.php/ap/logout') : include './component/logout.php'; ?>
    <?php elseif(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) == '/index.php/ap/verify') : include './component/verify.php'; ?>
    <?php elseif($_SERVER['REQUEST_URI'] == '/index.php/ap/signin') : include './component/signin.php'; ?>
    <?php else: ?>
    <div class="flex-row flex items-center bg-bg-white min-h-screen w-full">
        <!-- sidebar  -->
        <div data-state="closed" class="data-[state=closed]:animate-slide-out data-[state=open]:animate-slide-in ease-in-out transition duration-150 max-sm:absolute h-screen w-full max-w-[256px] max-sm:left-[-256px] flex flex-col justify-between pb-4 bg-bg-white-smoke pt-4 pl-4 pr-4"
            id="sidebar">
            <div>
                <div class="flex items-center justify-between">
                    <span>
                        <img src="/static/brand-short-logo.png" class="rounded-[50%]" alt="brand_logo"
                            style="width: 28px; height: 28px;">
                    </span>
                    <div class="max-sm:block hidden select-none">
                        <span onclick="document.getElementById('sidebar').classList.toggle('max-sm:left-[-256px]');document.getElementById('sidebar').setAttribute('data-state', 'closed')" class="material-symbols-rounded p-2 rounded-[50%] hover:bg-bg-grey cursor-pointer"
                        style="font-size: 18px !important;">
                        close
                        </span>
                    </div>
                </div>
                <div class="mt-4">
                    <div onclick="location.href='/'" class="flex transition-all duration-200 items-center gap-2 cursor-pointer text-text-charcoal hover:text-text-rich-navy hover:bg-bg-grey rounded-[10px] pl-1">
                        <span class="material-symbols-rounded p-2 rounded-[50%] ">
                            add
                        </span>
                        <span class="text-[14px] ">New Chat</span>
                    </div>
                    <div class="mt-5" id="chatsDiv">
                        <div class="bg-transparent" popover id="chatmoreoptions" anchor="chatmoreoptions">
                            <style>
                                [popover] {
                                    inset: unset;
                                    top: anchor(top);
                                    left: anchor(right);
                                }
                            </style>
                            <script>
                                let currentchatId = null;
                                document.addEventListener('DOMContentLoaded', () => {
                                    const btns = document.querySelectorAll('button[popovertarget="chatmoreoptions"]');
                                    btns.forEach((btn) => {
                                        btn.addEventListener('click', (event) => {
                                            currentchatId = event.currentTarget.id;
                                        });
                                    });
                                });

                                function chatJsonToMarkdown(conversation, opts = {}) {
                                    const roleMap = { assistant: 'Kith', user: 'User' };
                                    const title = opts.title || 'Conversation with Kith';
                                    const lines = [`# ${title}`, '', ''];
                                    conversation.forEach(msg => {
                                    const who = roleMap[msg.role] || msg.role;
                                    // Preserve newlines in content
                                    const content = msg.content.replace(/\n/g, '\n\n');
                                    lines.push(`**${who}:** ${content}`, '');
                                    });
                                    return lines.join('\n');
                                }

                                function copycontentoption(){
                                    const chatId = currentchatId;
                                    const messages = chatJsonToMarkdown(JSON.parse(localStorage.getItem('chat_' + chatId)), {title: localStorage.getItem(chatId)});
                                    navigator.clipboard.writeText(messages).then(() => {
                                       Notification.requestPermission().then(permission => {
                                            if (permission === 'granted') {
                                                // Permission granted, now create the notification.
                                                new Notification('Text copied to clipboard!');
                                            }
                                        });
                                    });
                                }

                                function deletecontentoption() {
                                    const chatId = currentchatId;
                                    if (confirm('Are you sure you want to delete this chat?')) {
                                        localStorage.removeItem('chat_' + chatId);
                                        localStorage.removeItem(chatId);
                                        if(window.location.pathname.split('/').pop() == chatId) {
                                            window.location.href = '/';
                                        }else window.location.reload();
                                    }
                                }

                                function sharecontentoption() {
                                    const chatId = currentchatId;
                                    navigator.share({title: 'TasteAi', text: "Here’s my full cooking chat with Kith AI — see how the recipe came to life!", url: `http://localhost/index.php/c/${chatId}`}).catch(err => console.error('Error sharing:', err))
                                }
                            </script>
                                <ul class="bg-bg-white border border-border-grey rounded-[10px] p-1.5 shadow-sm">
                                    <li  onclick="sharecontentoption();document.getElementById('chatmoreoptions').hidePopover();" class="py-1.5 px-2.5 list-none hover:bg-bg-grey cursor-pointer group __menu-item gap-1.5 flex items-center rounded-[10px] text-sm">
                                        <span class="material-symbols-rounded flex items-center justify-center group-disabled:opacity-50 group-data-disabled:opacity-50">
                                            share
                                        </span>
                                        <span>Share</span>
                                    </li>
                                    <li  onclick="copycontentoption();document.getElementById('chatmoreoptions').hidePopover();" class="py-1.5 px-2.5 list-none hover:bg-bg-grey cursor-pointer group __menu-item gap-1.5 flex items-center rounded-[10px] text-sm">
                                        <span class="material-symbols-rounded  flex items-center justify-center group-disabled:opacity-50 group-data-disabled:opacity-50">
                                            content_copy
                                        </span>
                                        <span>Copy</span>
                                    </li>
                                    <li  onclick="deletecontentoption();document.getElementById('chatmoreoptions').hidePopover();" class="py-1.5 px-2.5 list-none hover:bg-bg-grey cursor-pointer group __menu-item gap-1.5 flex items-center rounded-[10px] text-sm">
                                        <span class="material-symbols-rounded flex items-center justify-center group-disabled:opacity-50 group-data-disabled:opacity-50">
                                            delete
                                        </span>
                                        <span>Delete</span>
                                    </li>
                                </ul>
                            </div>
                        <h4 class="text-text-slate-grey text-[14px] mb-2">Chats</h4>
                        <script type="module">
                            import { giveChatName } from './title.js';
                            const chatIds = Object.keys(localStorage).filter(key => key.startsWith('chat_'));
                            const chatsDiv = document.getElementById('chatsDiv');
                            chatIds.forEach(chatId => {
                                const title = localStorage.getItem(chatId.slice(5)) || 'New Chat';
                                const chatLinkDiv = document.createElement('div');
                                chatLinkDiv.className = 'px-2.5 py-1.5 flex transition-all duration-200 justify-between items-center cursor-pointer text-text-charcoal hover:text-text-rich-navy hover:bg-bg-grey rounded-[10px] group';
                                chatLinkDiv.id = chatId;
                                chatLinkDiv.innerHTML = `
                                    <a href="/index.php/c/${chatId.slice(5)}" class="text-[14px]">${title}</a>
                                    <button id="${chatId.slice(5)}" type="button" popovertarget="chatmoreoptions" class="cursor-pointer material-symbols-rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        more_vert
                                    </button>
                                `;
                                chatsDiv.appendChild(chatLinkDiv);
                            });
                                
                        </script>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="flex flex-col gap-2 select-none">
                    <button popovertarget="useroptionsmenu" class="p-2 transition-all duration-200 hover:text-text-rich-navy text-text-charcoal flex items-center gap-2 cursor-pointer hover:bg-bg-grey rounded-[10px]">
                        <img src="<?php echo $_SESSION['user']['picture']; ?>" alt="user-profile-img" class="rounded-[50%] h-6 w-6">
                        <span class="text-[14px] "><?php echo $_SESSION['user']['name']; ?></span>
                    </button>
                    <style>
                        #useroptionsmenu[popover]{
                            top: unset;
                            bottom: anchor(top);
                            left: anchor(left);
                            width: anchor-size(width);
                        }
                    </style>
                    <div id="useroptionsmenu" class="bg-transparent" popover="auto" anchor="useroptionsmenu">
                        <ul class="bg-bg-white border border-border-grey rounded-[10px] p-1.5 shadow-sm w-full">
                            <li onclick="document.getElementById('useroptionsmenu').hidePopover();window.location.href='/index.php/ap/logout'" class="py-1.5 px-2.5 list-none hover:bg-bg-grey cursor-pointer group __menu-item gap-1.5 flex items-center rounded-[10px] text-sm">
                                <span class="material-symbols-rounded flex items-center justify-center group-disabled:opacity-50 group-data-disabled:opacity-50">
                                    chip_extraction
                                </span>
                                <span>Sign Out</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php if($_SERVER['REQUEST_URI'] == '/index.php/settings') : include './component/settings.php'; ?>
        <?php elseif($_SERVER['REQUEST_URI'] == '/index.php/activities') : include './component/activities.php'; ?>
        <?php else: ?>
        <!-- main content -->
        <div class="h-screen bg-bg-white w-full max-md:px-4 max-sm:px-0">
            <div class="h-[36px] pt-2 pb-1.5  w-full mt-4 mb-3 flex justify-between items-center px-4">
                <div class="flex items-center justify-between gap-2">
                    <div class="block sm:hidden select-none"
                        onclick="document.querySelector('#sidebar').classList.toggle('max-sm:left-[-256px]');document.getElementById('sidebar').setAttribute('data-state', 'open')">
                        <span class="material-symbols-rounded p-2 rounded-[50%] hover:bg-bg-grey cursor-pointer"
                            style="font-size: 18px !important;">
                            menu
                        </span>
                    </div>
                    <h1 class="font-qurova font-[500] text-text-black text-4xl select-none">Kith</h1>
                </div>
                <div>
                    <div>
                        <img src="<?php echo $_SESSION['user']['picture']; ?>" alt="profile_image"
                            class="rounded-[50%] h-8 w-8 select-none">
                    </div>
                </div>
            </div>
            <div class="max-w-[760px] w-full mx-auto flex-col flex justify-between h-[70vh]">
                <!-- message  -->
                <div id="message-container"
                    class="pt-4  flex flex-col gap-8 max-sm:px-4 max-sm:pb-5 h-full overflow-y-auto overflow-x-hidden">
                    <div id="chat" class="flex flex-col gap-2.5 list-disc ">
                        <div id="chat-wlc" class="flex items-center justify-center h-[70vh] pointer-events-none">
                            <h1 class="text-4xl tracking-tight font-medium text-text-rich-navy">Hello,
                                <?php echo $_SESSION['user']['name']; ?>
                            </h1>
                        </div>
                        
                        <script type="module" src="/main.js"></script>
                    </div>
                </div>

            </div>
            <div class="max-sm:px-4">
                <form id="chat-form">
                    <div class="border p-2 rounded-3xl border-border-grey border-solid max-w-[758px] w-full mx-auto">
                        <input type="text" id="prompt" placeholder="Ask Kith" autocomplete="off"
                            class="w-full outline-none text-lg placeholder:text-18 px-3 py-[9px]">
                        <!-- Hidden submit button so pressing Enter reliably triggers form submission in all browsers -->
                        <button type="submit" class="hidden" tabindex="-1" aria-hidden="true"></button>
                        <!-- options  -->
                        <div class="flex items-center justify-between mt-2">
                            <div class="flex items-center gap-3">
                                <span style="display: none;" class="max-sm:hidden material-symbols-rounded p-2 hover:bg-bg-grey rounded-[50%] cursor-pointer">
                                    add
                                </span>
                                <button type="button" anchor="occasionsmenu" popovertarget="occasionsmenu" class="flex  items-center justify-center p-2 hover:bg-bg-grey rounded-xl">
                                    <span class="material-symbols-rounded cursor-pointer">
                                        celebration
                                    </span>
                                    <span class="max-sm:hidden text-sm cursor-pointer pl-1">Moments</span>
                                </button>
                                <div id="occasionsmenu" class="bg-transparent" popover>
                                    <style>
                                        #occasionsmenu[popover]{
                                            top: unset !important;
                                            bottom: anchor(top) !important;
                                            left: anchor(left) !important;
                                        }
                                    </style>
                                    <ul class="bg-bg-white border border-border-grey rounded-[10px] p-1.5 shadow-sm">
                                        <button type="button" popovertarget="emotion-popover" class="w-full py-1.5 px-2.5 list-none hover:bg-bg-grey cursor-pointer group __menu-item gap-1.5 flex items-center rounded-[10px] text-sm">
                                            <span>Feelings</span>
                                            <div id="emotion-popover" popover class="bg-transparent">
                                                <ul class="bg-bg-white border border-border-grey rounded-[10px] p-1.5 shadow-sm">
                                                    <li onclick="getOccasion('Valentine');document.getElementById('emotion-popover').hidePopover();document.getElementById('occasionsmenu').hidePopover();" class="py-1.5 px-2.5 list-none hover:bg-bg-grey cursor-pointer group __menu-item gap-1.5 flex items-center rounded-[10px] text-sm">
                                                        <span>Valentine/Propose</span>
                                                    </li>
                                                    <li onclick="getOccasion('marriage');document.getElementById('emotion-popover').hidePopover();document.getElementById('occasionsmenu').hidePopover();" class="py-1.5 px-2.5 list-none hover:bg-bg-grey cursor-pointer group __menu-item gap-1.5 flex items-center rounded-[10px] text-sm">
                                                        <span>Marriage</span>
                                                    </li>
                                                    <li onclick="getOccasion('breakup comeback');document.getElementById('emotion-popover').hidePopover();document.getElementById('occasionsmenu').hidePopover();" class="py-1.5 px-2.5 list-none hover:bg-bg-grey cursor-pointer group __menu-item gap-1.5 flex items-center rounded-[10px] text-sm">
                                                        <span>Breakup Comeback</span>
                                                    </li>
                                                    <li onclick="getOccasion('surprise');document.getElementById('emotion-popover').hidePopover();document.getElementById('occasionsmenu').hidePopover();" class="py-1.5 px-2.5 list-none hover:bg-bg-grey cursor-pointer group __menu-item gap-1.5 flex items-center rounded-[10px] text-sm">
                                                        <span>Surprise</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </button>
                                        <button type="button" popovertarget="festival-popover" class="w-full py-1.5 px-2.5 list-none hover:bg-bg-grey cursor-pointer group __menu-item gap-1.5 flex items-center rounded-[10px] text-sm">
                                            <span>Festival</span>
                                            <div id="festival-popover" popover class="bg-transparent">
                                                <ul class="bg-bg-white border border-border-grey rounded-[10px] p-1.5 shadow-sm">
                                                    <li onclick="getOccasion('Diwali');document.getElementById('festival-popover').hidePopover();document.getElementById('occasionsmenu').hidePopover();" class="py-1.5 px-2.5 list-none hover:bg-bg-grey cursor-pointer group __menu-item gap-1.5 flex items-center rounded-[10px] text-sm">
                                                        <span>Diwali</span>
                                                    </li>
                                                    <li onclick="getOccasion('Raksha Bandhan');document.getElementById('festival-popover').hidePopover();document.getElementById('occasionsmenu').hidePopover();" class="py-1.5 px-2.5 list-none hover:bg-bg-grey cursor-pointer group __menu-item gap-1.5 flex items-center rounded-[10px] text-sm">
                                                        <span>Raksha Bandhan</span>
                                                    </li>
                                                    <li onclick="getOccasion('Holi');document.getElementById('festival-popover').hidePopover();document.getElementById('occasionsmenu').hidePopover();" class="py-1.5 px-2.5 list-none hover:bg-bg-grey cursor-pointer group __menu-item gap-1.5 flex items-center rounded-[10px] text-sm">
                                                        <span>Holi</span>
                                                    </li>
                                                    <li onclick="getOccasion('New Year');document.getElementById('festival-popover').hidePopover();document.getElementById('occasionsmenu').hidePopover();" class="py-1.5 px-2.5 list-none hover:bg-bg-grey cursor-pointer group __menu-item gap-1.5 flex items-center rounded-[10px] text-sm">
                                                        <span>New Year</span>
                                                    </li>
                                                    <li onclick="getOccasion('Halloween');document.getElementById('festival-popover').hidePopover();document.getElementById('occasionsmenu').hidePopover();" class="py-1.5 px-2.5 list-none hover:bg-bg-grey cursor-pointer group __menu-item gap-1.5 flex items-center rounded-[10px] text-sm">
                                                        <span>Halloween</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </button>
                                        <button type="button" popovertarget="birthday-popover" class="w-full py-1.5 px-2.5 list-none hover:bg-bg-grey cursor-pointer group __menu-item gap-1.5 flex items-center rounded-[10px] text-sm">
                                            <span>Birthday</span>
                                            <div id="birthday-popover" popover class="bg-transparent">
                                                <ul class="bg-bg-white border border-border-grey rounded-[10px] p-1.5 shadow-sm">
                                                    <li onclick="getOccasion('Girlfriend\'s Birthday');document.getElementById('birthday-popover').hidePopover();document.getElementById('occasionsmenu').hidePopover();" class="py-1.5 px-2.5 list-none hover:bg-bg-grey cursor-pointer group __menu-item gap-1.5 flex items-center rounded-[10px] text-sm">
                                                        <span>Girlfriend's Birthday</span>
                                                    </li>
                                                    <li onclick="getOccasion('Boyfriend\'s Birthday');document.getElementById('birthday-popover').hidePopover();document.getElementById('occasionsmenu').hidePopover();" class="py-1.5 px-2.5 list-none hover:bg-bg-grey cursor-pointer group __menu-item gap-1.5 flex items-center rounded-[10px] text-sm">
                                                        <span>Boyfriend's Birthday</span>
                                                    </li>
                                                    <li onclick="getOccasion('Friend\'s Birthday');document.getElementById('birthday-popover').hidePopover();document.getElementById('occasionsmenu').hidePopover();" class="py-1.5 px-2.5 list-none hover:bg-bg-grey cursor-pointer group __menu-item gap-1.5 flex items-center rounded-[10px] text-sm">
                                                        <span>Friend's Birthday</span>
                                                    </li>
                                                    <li onclick="getOccasion('Parent\'s Birthday');document.getElementById('birthday-popover').hidePopover();document.getElementById('occasionsmenu').hidePopover();" class="py-1.5 px-2.5 list-none hover:bg-bg-grey cursor-pointer group __menu-item gap-1.5 flex items-center rounded-[10px] text-sm">
                                                        <span>Parent's Birthday</span>
                                                    </li>
                                                    <li onclick="getOccasion('Sibling\'s Birthday');document.getElementById('birthday-popover').hidePopover();document.getElementById('occasionsmenu').hidePopover();" class="py-1.5 px-2.5 list-none hover:bg-bg-grey cursor-pointer group __menu-item gap-1.5 flex items-center rounded-[10px] text-sm">
                                                        <span>Sibling's Birthday</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </button>
                                        <button type="button" popovertarget="anniversary-popover" class="w-full py-1.5 px-2.5 list-none hover:bg-bg-grey cursor-pointer group __menu-item gap-1.5 flex items-center rounded-[10px] text-sm">
                                            <span>Anniversary</span>
                                            <div id="anniversary-popover" popover class="bg-transparent">
                                                <ul class="bg-bg-white border border-border-grey rounded-[10px] p-1.5 shadow-sm">
                                                    <li onclick="getOccasion('Wedding Anniversary');document.getElementById('anniversary-popover').hidePopover();document.getElementById('occasionsmenu').hidePopover();" class="py-1.5 px-2.5 list-none hover:bg-bg-grey cursor-pointer group __menu-item gap-1.5 flex items-center rounded-[10px] text-sm">
                                                        <span>Wedding Anniversary</span>
                                                    </li>
                                                    <li onclick="getOccasion('Friend\'s Anniversary');document.getElementById('anniversary-popover').hidePopover();document.getElementById('occasionsmenu').hidePopover();" class="py-1.5 px-2.5 list-none hover:bg-bg-grey cursor-pointer group __menu-item gap-1.5 flex items-center rounded-[10px] text-sm">
                                                        <span>Friend's Anniversary</span>
                                                    </li>
                                                    <li onclick="getOccasion('Relationship Anniversary');document.getElementById('anniversary-popover').hidePopover();document.getElementById('occasionsmenu').hidePopover();" class="py-1.5 px-2.5 list-none hover:bg-bg-grey cursor-pointer group __menu-item gap-1.5 flex items-center rounded-[10px] text-sm">
                                                        <span>Relationship Anniversary</span>
                                                    </li>
                                                    <li onclick="getOccasion('Other Anniversaries');document.getElementById('anniversary-popover').hidePopover();document.getElementById('occasionsmenu').hidePopover();" class="py-1.5 px-2.5 list-none hover:bg-bg-grey cursor-pointer group __menu-item gap-1.5 flex items-center rounded-[10px] text-sm">
                                                        <span>Other Anniversaries</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </button>
                                        <button type="button" class="w-full py-1.5 px-2.5 list-none hover:bg-bg-grey cursor-pointer group __menu-item gap-1.5 flex items-center rounded-[10px] text-sm">
                                            <span onclick="getOccasion('Weekend/Holiday');document.getElementById('occasionsmenu').hidePopover();">Weekend/Holiday</span>
                                        </button>
                                        <button type="button" popovertarget="other-popover" class="w-full py-1.5 px-2.5 list-none hover:bg-bg-grey cursor-pointer group __menu-item gap-1.5 flex items-center rounded-[10px] text-sm">
                                            <span>Specify Occasion</span>
                                            <div id="other-popover" popover class="bg-transparent">
                                                <ul class="bg-bg-white border border-border-grey rounded-[10px] p-1.5 shadow-sm">
                                                    <input type="text" onchange="getOccasion(this.value);document.getElementById('occasionsmenu').hidePopover();" placeholder="Specify Occasion" class="border border-border-grey rounded-[10px] p-1.5 w-full" />
                                                </ul>
                                            </div>
                                        </button>
                                    </ul>
                                </div>
                                <!-- Occasion selection pill container -->
                                <div id="occasion-tags" class="flex flex-wrap gap-2"></div>
                            </div>
                            <div>
                                <span id="subspan"
                                    class="material-symbols-rounded bg-bg-white-smoke text-text-slate-grey p-2 rounded-[50%] hover:bg-bg-rich-navy hover:text-text-white cursor-pointer">
                                    send
                                </span>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="flex whitespace-nowrap items-center justify-center mt-2 select-none pointer-events-none mb-4 max-sm:flex-col max-sm:pb-4 max-sm:gap-2">
                    <span class="text-sm text-text-slate-grey max-sm:text-xs break-words"> © 2025 Slew. All rights reserved. Kith is a product of Slew. </span>
                    <span class="text-sm text-text-slate-grey flex items-center justify-center pl-[3px]">Powered By <img class="h-[15px] pl-1" src="/static/slew_purple_logo.webp" alt="slew_logo_purple"></span>
                </div>
            </div>
        </div>
        <script type="module" src="/index.js"></script>
        

        <?php endif; ?>
    </div>
    <?php endif; ?>
</body>

</html>

import * as smd from "https://cdn.jsdelivr.net/npm/streaming-markdown/smd.min.js"
import { giveChatName } from '/static/title.js';

let chatbox, form, promptinput, chatsDiv, subspan;
let chatId = window.location.pathname.split('/').pop();
let messages = JSON.parse(localStorage.getItem('chat_' + chatId)) || [];

let occasion = null; // internal state

export function getCurrentOccasion(){ return occasion; }

export function getOccasion(occ) {
    occasion = occ || null;
    if(occasion){
        localStorage.setItem('current_occasion', occasion);
    } else {
        localStorage.removeItem('current_occasion');
    }
    updateOccasionTag();
} 

if (typeof window !== 'undefined') window.getOccasion = getOccasion;


document.addEventListener("DOMContentLoaded", function () {
    chatbox = document.getElementById('chat');
    form = document.getElementById('chat-form');
    promptinput = document.getElementById('prompt');
    chatsDiv = document.getElementById('chatsDiv');
    subspan = document.getElementById('subspan');

    if(subspan){
        subspan.addEventListener("click", () => {
            form?.dispatchEvent(new Event('submit', { bubbles: true, cancelable: true }));
        });
    }

    // Fallback: if Enter key pressed inside prompt input and not shift+enter, submit
    if(promptinput){
        promptinput.addEventListener('keydown', (e) => {
            if(e.key === 'Enter' && !e.shiftKey){
                e.preventDefault();
                form?.dispatchEvent(new Event('submit', { bubbles: true, cancelable: true }));
            }
        });
    }

    // Restore persisted occasion
    const storedOccasion = localStorage.getItem('current_occasion');
    if(storedOccasion){
        occasion = storedOccasion;
        updateOccasionTag();
    }

    form?.addEventListener('submit', handleChatSubmit);
});

function updateOccasionTag(){
    const container = document.getElementById('occasion-tags');
    if(!container) return;
    container.innerHTML = '';
    if(!occasion) return;
    const pill = document.createElement('div');
    pill.className = 'flex items-center gap-1.5 px-2 py-1 text-sm bg-bg-grey text-text-rich-navy rounded-[10px] cursor-pointer hover:bg-bg-white-smoke';
    pill.innerHTML = `<span class="truncate max-w-[140px]">${occasion}</span><span class="material-symbols-rounded text-[16px] leading-none">close</span>`;
    pill.title = 'Click to remove occasion';
    pill.addEventListener('click', () => getOccasion(null));
    container.appendChild(pill);
}

async function handleChatSubmit(e){
    e.preventDefault();

    if(window.location.pathname == '/index.php/' || window.location.pathname == '/') {
        const _chatId = crypto.randomUUID();
        window.history.pushState({}, '', 'index.php/c/' + _chatId);
        chatId = _chatId; // Update chatId to the new one
        localStorage.setItem('chat_' + _chatId, JSON.stringify([]));
        const chatLinkDiv = document.createElement('div');
        chatLinkDiv.className = 'px-2.5 py-1.5 flex transition-all duration-200 justify-between items-center cursor-pointer text-text-charcoal hover:text-text-rich-navy hover:bg-bg-grey rounded-[10px] group';
        chatLinkDiv.id = 'chat_'+_chatId;
        chatLinkDiv.innerHTML = `
            <a href="/index.php/c/${_chatId}" class="text-[14px]">New Chat</a>
            <button id="${_chatId}" type="button" popovertarget="chatmoreoptions" class="cursor-pointer material-symbols-rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                more_vert
            </button>
        `;
        chatsDiv.appendChild(chatLinkDiv);
        document.querySelector(`button[id="${_chatId}"]`).addEventListener('click', (event) => {
            currentchatId = event.currentTarget.id;
        });
    }

    const usertext = promptinput.value.trim();
    if (!usertext) return;

    const wlc = document.getElementById("chat-wlc");
    if (wlc) {
        wlc.remove();
    }

    messages.push({
        role: 'user',
        content: usertext
    });

    const usermessage = document.createElement('div');
    usermessage.className = "py-3 px-4 ml-auto rounded-tl-2xl rounded-bl-2xl rounded-br-2xl text-right max-w-fit bg-bg-grey";
    usermessage.textContent = usertext;
    chatbox.appendChild(usermessage);
    chatbox.scrollTop = chatbox.scrollHeight;

    promptinput.value = '';
    const rand = Math.floor(Math.random() * 1000000);

    const botBubble = document.createElement('div');
    const cursor = document.createElement('div');
    botBubble.className = 'flex flex-col gap-3 w-full max-w-fit px-3 pt-4 pb-4';
    cursor.className = 'mt-[-36px] ml-4 px-4 break-words';
    cursor.id = `${rand}`;
    var icon = `<div class="w-8 h-8 ml-[-10px]">
                                <img src="/static/brand-short-logo.png" class="select-none pointer-events-none mt-1 rounded-[50%]" alt="taste_ai" width="36" height="36">
                            </div>`;
    const optionsDiv = document.createElement('div');
    optionsDiv.id = 'options';
    optionsDiv.className = " pl-4 flex items-center h-[52px] select-none opacity-0";
    optionsDiv.innerHTML = `
                                <div class="w-8 h-[48px] flex items-center">
                                    <span class="material-symbols-rounded hover:bg-bg-grey p-1.5 rounded-[50%] cursor-pointer" style="font-size: 18px !important;"
                                    onclick="this.classList.add('bg-bg-rich-navy'); this.classList.remove('hover:bg-bg-grey'); this.classList.add('text-text-white');">
                                        thumb_up
                                    </span>
                                </div>
                                <div class="w-8 h-[48px] flex items-center justify-center">
                                    <span class="material-symbols-rounded hover:bg-bg-grey p-1.5 rounded-[50%] cursor-pointer" style="font-size: 18px !important;"
                                    onclick="navigator.share({title: 'KithAi', text: document.getElementById('${rand}').textContent, url: window.location.href}).catch(err => console.error('Error sharing:', err))">
                                        share
                                    </span>
                                </div>
                                <div class="w-8 h-[48px] flex items-center justify-center">
                                    <span class="material-symbols-rounded hover:bg-bg-grey p-1.5 rounded-[50%] cursor-pointer" style="font-size: 18px !important;" onclick="navigator.clipboard.writeText(document.getElementById('${rand}').textContent)">
                                        content_copy
                                    </span>
                                </div>
                            `;
    botBubble.insertAdjacentHTML('beforeend', icon);
    botBubble.appendChild(cursor);
    botBubble.appendChild(optionsDiv);
    chatbox.appendChild(botBubble);
    chatbox.scrollTop = chatbox.scrollHeight;

    const renderer = smd.default_renderer(cursor);
    const parser = smd.parser(renderer);


    const response = await fetch('/chat.php', {
        method: "POST",
        headers: { 'Content-type': 'application/x-www-form-urlencoded', 'X-Bearer-Token': 'Ansh by Slew' },
        body: new URLSearchParams({ prompt: `${usertext} ${occasion != null ? 'Occasion: ' + occasion : ''}`, chat_history: JSON.stringify(messages.slice(-10)) }),
    })

    const reader = response.body.getReader();
    const decoder = new TextDecoder();
    let buffer = '';
    let markdownText = '';

    while (true) {
        const { done, value } = await reader.read();
        if (done) break;
        const chunk = decoder.decode(value, { stream: true });
        buffer += chunk;

        const lines = buffer.split('\n');

        for (const line of lines) {
            if (!line.startsWith('data: ')) continue;

            try {
                const json = JSON.parse(line.slice(5).trim());
                const text = json?.choices?.[0]?.delta?.content;
                // let livebuffer = '';  
                if (text) {
                    smd.parser_write(parser, text);
                    markdownText += text;
                    await new Promise(r => setTimeout(r, 15));

                    chatbox.scrollTop = chatbox.scrollHeight;
                }


            }
            catch (err) {
                // ignore
            }
        }

        buffer = '';
    }


    smd.parser_end(parser)
    // const optionss = document.getElementById('options');
    optionsDiv.classList.remove('opacity-0');
    optionsDiv.classList.add('opacity-100');
    messages.push({
        role: 'assistant',
        content: markdownText
    });
    localStorage.setItem('chat_' + chatId, JSON.stringify(messages));
    var title = await giveChatName(messages);
    localStorage.setItem(chatId, title);
    markdownText = '';

}

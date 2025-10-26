const chatId = window.location.pathname.split('/').pop();
const chatMessages = JSON.parse(localStorage.getItem('chat_' + chatId)) || [];
const chatContainer = document.getElementById('chat');


if (chatMessages.length > 0) {
    const wlc = document.getElementById("chat-wlc");
    if (wlc) {
        wlc.remove();
    }
}

if(document.getElementById('chat_' + chatId)){
    document.getElementById('chat_' + chatId).classList.add('bg-bg-grey', 'text-text-rich-navy');
}

chatMessages.forEach(message => {
    if (message.role === 'user') {
        chatContainer.innerHTML += `<div class="py-3 px-4 ml-auto rounded-tl-2xl rounded-bl-2xl rounded-br-2xl text-right max-w-fit bg-bg-grey">${message.content}</div>`;
    } else {
        const htmlContent = marked.parse(message.content);
        const uniqueId = crypto.randomUUID();
        chatContainer.innerHTML += `
                                    <div class="flex flex-col gap-3 w-full max-w-fit px-3 pt-4 pb-4"><div class="w-8 h-8 ml-[-10px]">
                                <img src="/static/brand-short-logo.png" class="select-none pointer-events-none mt-1 rounded-[50%]" alt="taste_ai" width="36" height="36">
                            </div><div class="mt-[-36px] ml-4 px-4 break-words" id="${uniqueId}">${htmlContent}</div><div id="options" class="pl-4 flex items-center h-[52px] select-none opacity-100">
                                <div class="w-8 h-[48px] flex items-center">
                                    <span class="material-symbols-rounded hover:bg-bg-grey p-1.5 rounded-[50%] cursor-pointer" style="font-size: 18px !important;"
                                    onclick="this.classList.add('bg-bg-rich-navy'); this.classList.remove('hover:bg-bg-grey'); this.classList.add('text-text-white');">
                                        thumb_up
                                    </span>
                                </div>
                                <div class="w-8 h-[48px] flex items-center justify-center">
                                    <span class="material-symbols-rounded hover:bg-bg-grey p-1.5 rounded-[50%] cursor-pointer" style="font-size: 18px !important;"
                                    onclick="navigator.share({title: 'TasteAi', text: document.getElementById('${uniqueId}').textContent, url: window.location.href}).catch(err => console.error('Error sharing:', err))">
                                        share
                                    </span>
                                </div>
                                <div class="w-8 h-[48px] flex items-center justify-center">
                                    <span class="material-symbols-rounded hover:bg-bg-grey p-1.5 rounded-[50%] cursor-pointer" style="font-size: 18px !important;" onclick="navigator.clipboard.writeText(document.getElementById('${uniqueId}').textContent)">
                                        content_copy
                                    </span>
                                </div>
                            </div></div>
                                    `;
    }
});
<div class="h-screen bg-bg-white w-full ">
            <div class="h-[36px] pt-1.5 pb-1.5  w-full mt-3 mb-3 flex justify-between items-center px-4">
                <div class="flex items-center justify-between gap-2">
                    <div class="block sm:hidden select-none"
                        onclick="document.querySelector('#sidebar').classList.toggle('max-sm:hidden');">
                        <span class="material-symbols-rounded p-2 rounded-[50%] hover:bg-bg-grey cursor-pointer"
                            style="font-size: 18px !important;">
                            menu
                        </span>
                    </div>
                    <h1 class="font-kinds-sans font-[500] text-text-black text-2xl">Activities</h1>
                </div>
                <div>
                    <div>
                        <img src="<?php echo $_SESSION['user']['picture']; ?>" alt="profile_image"
                            class="rounded-[50%] h-8 w-8">
                    </div>
                </div>
            </div>
            <div class="max-w-[760px] w-full mx-auto flex-col flex justify-between h-[90vh]">
                <!-- message  -->
                <div id="message-container"
                    class="pt-4  flex flex-col gap-8 max-sm:px-4 max-sm:pb-5 h-full overflow-y-auto overflow-x-hidden">
                    <div id="chat" class="flex flex-col gap-2.5 list-disc ">
                        <script>
                            const chatMessages = JSON.parse(localStorage.getItem('chat_messages')) || [];
                            const chatContainer = document.getElementById('chat');

                            chatMessages.forEach(message => {
                                if(message.role === 'user') {
                                    chatContainer.innerHTML += `<div class="py-3 px-4 ml-auto rounded-tl-2xl rounded-bl-2xl rounded-br-2xl text-right max-w-fit bg-bg-grey">${message.content}</div>`;
                                } else {
                                    chatContainer.innerHTML += `
                                    <div class="flex flex-col gap-3 w-full max-w-fit px-3 pt-4 pb-4"><div class="w-8 h-8 ml-[-10px]">
                                <img src="/static/brand-short-logo.png" class="select-none pointer-events-none mt-1 rounded-[50%]" alt="taste_ai" width="36" height="36">
                            </div><div class="mt-[-36px] ml-4 px-4 break-words" id="hi769225">${message.content}</div><div id="options" class="pl-4 flex items-center h-[52px] select-none opacity-100">
                                
                            </div></div>
                                    `;
                                }
                            });
                        </script>
                    </div>
                </div>
            </div>
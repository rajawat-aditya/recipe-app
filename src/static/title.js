export async function giveChatName(messages) {
    const response = await fetch('https://50zewoomz6.execute-api.ap-south-1.amazonaws.com/title.php', {
        method: "POST",
        headers: { 'Content-type': 'application/x-www-form-urlencoded', 'X-Bearer-Token': 'Ansh by Slew' },
        body: new URLSearchParams({ chat_history: JSON.stringify(messages) }),
    })
    
    const reader = response.body.getReader();
    const decoder = new TextDecoder();
    let buffer = '';
    let title = '';

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
                        title += text;
                        await new Promise(r => setTimeout(r, 15));
                    }

                }
                catch (err) {
                    // ignore
                }
            }
    
            buffer = '';
        }

    return title.trim();
}


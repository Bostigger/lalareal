<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Chat Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex">

            <!-- Online Users Section -->
            <div class="w-1/4 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="font-bold text-lg mb-4">Online Users</h3>
                    <ul id="onlineUsers">

                    </ul>
                </div>
            </div>

            <!-- Chat Area -->
            <div class="w-3/4 bg-white dark:bg-gray-800 ml-4 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div id="chatArea" class="flex flex-col justify-start items-start h-64 overflow-y-auto">
                        <!-- Chat messages will populate here -->

                    </div>
                    <!-- Message Input Area -->
                    <div class="flex flex-row justify-between items-center mt-6">
                        <input type="text" id="messageInput" class="flex-grow rounded-md p-2 w-full required text-gray-400" placeholder="Type your message here...">
                        <button id="sendMessageBtn" class="ml-4 bg-blue-500 text-white p-2 rounded">Send</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function (){
            const chatArea = document.getElementById('chatArea');
            const sendMessageBtn = document.getElementById('sendMessageBtn');
            const messageInput = document.getElementById('messageInput');

            sendMessageBtn.addEventListener('click',(e)=>{
                e.preventDefault();
                window.axios.post('/send-message',{
                    message:messageInput.value
                }).then(response=>{
                    console.log(response)
                })
                messageInput.value = '';
            })
            if (window.Echo) {
                window.Echo.channel('chats')
                    .listen('SendMessageEvent', (e) => {
                        console.log(e)
                       let element = document.createElement('li');
                       element.innerText =  e.user.name + ' : ' +e.message
                        chatArea.append(element)
                    });
            }
        })
    </script>
</x-app-layout>

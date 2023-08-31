<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                  <div>
                    <ul id="users">

                    </ul>
                  </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    document.addEventListener("DOMContentLoaded", function (){
        const users = document.getElementById('users');
        window.axios.get('/api/users').then(response=>{
            console.log(response.data)
            response.data.forEach(user=>{
                let element = document.createElement('li');
                element.innerText = user.name
                users.append(element)
            })
        })
    })
</script>

<script>

    document.addEventListener("DOMContentLoaded", function () {
        const usersList = document.getElementById("users");
        if (window.Echo){
            window.Echo.channel("users")
                .listen('UserCreatedEvent',(e)=>{
                    let element = document.createElement('li');
                    element.setAttribute('id',e.user.id);
                    element.innerText = e.user.name;
                    usersList.append(element)
                }).listen('UserUpdatedEvent', (e)=>{
                    let UpdateElement = document.getElementById(e.user.id);
                    UpdateElement.innerText = e.user.name;
                }).listen('UserDeletedEvent',(e)=>{
                    let DeletedEle = document.getElementById(e.user.id)
                    DeletedEle.parentNode.removeChild(DeletedEle)

            })
        }
    })
</script>

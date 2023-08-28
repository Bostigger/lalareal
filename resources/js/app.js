import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

Echo.channel('notifications').listen('UserSessionChanged',(e)=>{
    const notificationElement =  document.getElementById('notification')
        notificationElement.classList.remove('invisible');
    notificationElement.innerText = e.message;
    notificationElement.classList.remove('text-green-300');
    notificationElement.classList.remove('text-red-300');

    notificationElement.classList.add('text-'+ e.messageType);

});


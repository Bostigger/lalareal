<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
     <style>
        .game-roulete{
            animation: rotate 3s linear infinite;
        }
        @keyframes rotate{
            0%{
                transform: rotate(0deg);
            }
            100%{
                transform: rotate(360deg);
            }
        }

     </style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div id="game" class="flex flex-col justify-center items-center">
                        <img id="circle"  src="{{asset('/images/circle.png')}}" alt="" style="height:300px;">
                        <p id="winner" class="display-1 d-none text-white"></p>
                        <div>
                            <br>
                            <label for="option">Pick a number</label> <br>
                            <select style="color: black" name="" id="bet">
                                <option  selected>Not In</option>
                            @foreach(range(1,12) as $num)
                                    <option  value="{{$num}}">{{$num}}</option>
                            @endforeach
                            </select>
                            <br><br>
                            <hr>
                            <p class="font-bold text-xl">Remaining Time</p>
                            <p id="timer" style="color:#97f559;" class="font-bold text-xl ">Waiting to start</p>
                            <hr>
                            <p id="winner" class="text-2xl"></p>
                            <p id="result" class="text-xl"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // ... other bootstrap imports and setups

        document.addEventListener("DOMContentLoaded", function() {
            const roulete = document.getElementById('circle');
            const timer = document.getElementById('timer');
            const winner = document.getElementById('winner');
            const bet = document.getElementById('bet');
            const result = document.getElementById('result');

            if (window.Echo) {
                window.Echo.channel('game')
                    .listen('RemainingTimeEvent', (e) => {
                        timer.innerText = e.time;
                        roulete.classList.add('game-roulete');
                        winner.classList.add('d-none');
                        result.innerText = '';
                        winner.innerText = '';

                    })
                    .listen('LuckyNumberEvent', (e) => {
                        roulete.classList.remove('game-roulete');
                        let winNumber = e.number;
                        winner.innerText = winNumber;
                        winner.classList.remove('d-none');
                        let betVal = bet[bet.selectedIndex].value;
                        console.log(betVal)
                        if (betVal == winNumber) {
                            result.innerText = 'You Win';
                        } else {
                            result.innerText = 'You Lose';
                        }

                    });
            }
        });



    </script>
</x-app-layout>




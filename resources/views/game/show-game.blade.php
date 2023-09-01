<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <h4 class="float-right text-xl text-indigo-700 ">Account Balance:  <span id="account"></span></h4>
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
                        <div class="flex flex-col justify-center items-center">
                            <br>
                            <label for="option">Predict Number</label> <br>
                            <select style="color: black" name="" id="bet">
                                <option  selected>Not In</option>
                            @foreach(range(1,12) as $num)
                                    <option  value="{{$num}}">{{$num}}</option>
                            @endforeach
                            </select>
                            <hr>
                            <br>
                            <input type="text" class="text-indigo-700" placeholder="multiplier" id="multiplier" name="multiplier"><br>
                            <input type="text" class="text-indigo-700" placeholder="amount" id="amount" name="amount"><br>

                            <button id="game-btn" class="w-full p-2 btn bg-gray-500" type="submit">Bet</button>
                            <hr>
                            <p class="font-bold text-xl">Remaining Time</p>
                            <p id="timer" style="color:#97f559;" class="font-bold text-xl ">Waiting to start</p>
                            <hr>
                            <p id="winner" class="text-2xl"></p>
                            <p id="result" class="text-xl"></p>
                            <p id="cash" class="text-2xl text-danger"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const gameBtn = document.getElementById('game-btn')
        const amount = document.getElementById('amount')
        const multiplier = document.getElementById('multiplier')
        const cash = document.getElementById('cash')
        gameBtn.addEventListener('click',(e)=>{
            e.preventDefault()
            console.log('first checkpoint')
            window.axios.post('/play-game',{
                money:amount.value,
                multiplier:multiplier.value
            }).then((response)=>{
                console.log(response)
            })


        })
    </script>
    <script>
        gameBtn.addEventListener('click',(e)=> {
            const amount = document.getElementById('amount').value
            fommatedAmount = parseInt(amount)
            console.log(typeof fommatedAmount)
            console.log(fommatedAmount)
        })

        document.addEventListener("DOMContentLoaded", function() {

            let potentialMoney = 0;
            let UserDefaultMoney = 100000;
            const roulete = document.getElementById('circle');
            const timer = document.getElementById('timer');
            const winner = document.getElementById('winner');
            const bet = document.getElementById('bet');
            const result = document.getElementById('result');
            const cash = document.getElementById('cash');
            let currentScore = localStorage.getItem('score');
            console.log(currentScore)
            if (!currentScore) {
                localStorage.setItem('score', parseInt(UserDefaultMoney));
            }
            account.innerText = '$'+currentScore;

            if (window.Echo) {
                window.Echo.channel('game')
                    .listen('RemainingTimeEvent', (e) => {
                        timer.innerText = e.time;
                        roulete.classList.add('game-roulete');
                        winner.classList.add('d-none');
                        result.innerText = '';
                        winner.innerText = '';

                    }).listen('MoneyMultiplierEvent',(e)=> {
                    cash.innerText = e.money
                    potentialMoney = e.money
                    })
                    .listen('LuckyNumberEvent', (e) => {
                        roulete.classList.remove('game-roulete');
                        let winNumber = e.number;
                        winner.innerText = winNumber;
                        winner.classList.remove('d-none');
                        let betVal = bet[bet.selectedIndex].value;
                        console.log(betVal)
                        console.log(currentScore)
                        if (betVal == winNumber) {
                             result.innerText = 'You Win';
                            currentScore = localStorage.getItem('score');
                             localStorage.setItem('score', parseInt(potentialMoney) + parseInt(fommatedAmount))
                             currentScore = localStorage.getItem('score');
                             cash.innerText= currentScore;
                            account.innerText = '$'+currentScore;
                        } else {
                            result.innerText = 'You Lose';
                            currentScore = localStorage.getItem('score');
                            localStorage.setItem('score', parseInt(currentScore)- parseInt(fommatedAmount));
                            currentScore = localStorage.getItem('score');
                            cash.innerText= currentScore;
                            account.innerText = '$'+currentScore;
                            }
                            console.log(currentScore)
                    });
            }
        });



    </script>
</x-app-layout>




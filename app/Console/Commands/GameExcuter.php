<?php

namespace App\Console\Commands;

use App\Events\LuckyNumberEvent;
use App\Events\MoneyMultiplierEvent;
use App\Events\RemainingTimeEvent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

class GameExcuter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $signature = 'game:execute';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Starts the game and executes the game logic';

    private $time = 15;
    /**
     * Execute the console command.
     */
    public function handle()
    {

       while (true){
           broadcast(new RemainingTimeEvent($this->time));
           broadcast(new MoneyMultiplierEvent(5,100));
           sleep(1);
           $this->time--;
           if ($this->time===0){
               $this->time="Waiting for next round";;
               broadcast(new RemainingTimeEvent($this->time));
               broadcast(new LuckyNumberEvent(mt_rand(1,12)));
               sleep(3);
               $this->time=15;;
           }
       }

    }
}

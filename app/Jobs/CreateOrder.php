<?php

namespace App\Jobs;

use App\Jobs\Job;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use App\Models\Orders\Entities\Order as Order;

class CreateOrder extends Job implements ShouldQueue
{
    use InteractsWithQueue;

    protected $order;
    /**
     * Create a new job instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->order;
    }

    public function handle(){
        //
    }

    /**
     * Listens to SQS queue and creates order from data
     *
     * @return void
     */

    public function fire(\Illuminate\Contracts\Queue\Job $job, $data){
        var_dump($data);
        throw new \Exception('test');
    }
}

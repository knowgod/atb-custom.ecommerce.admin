<?php

namespace App\Jobs;

use App\Jobs\Job;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use App\Models\Orders\Entities\Order as Order;
use Mockery\CountValidator\Exception;

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
        $orderData = $data['order'];
        $paymentData = $data['order_payment'];
        $this->setJob($job);
        try{
            $order = new Order();
            $order->setEmail($orderData['customer_email'])
                    ->setIncrementId($orderData['increment_id'])
                    ->setCustomerName($orderData['customer_firstname'] . ' ' . $data['order']['customer_lastname'])
                    ->setQty($orderData['total_qty_ordered'])
                    ->setStatus($orderData['status'])
                    ->setGrandTotal($orderData['grand_total'])
                    ->setDiscountAmount($orderData['discount_amount'])
                    ->setTotalPaid($orderData['grand_total'])
                    ->setShippingCountryCode('US')
                    ->setPaymentMethod($paymentData['method'])
                    ->setCouponCode($orderData['coupon_code'])
                    ->setWebsite('nume');
            //created and updated at
            $order->save();
            $this->delete();
            echo 'OK!';
        }catch (\Exception $e){
            Log::error($e->getMessage());
        }
    }
}

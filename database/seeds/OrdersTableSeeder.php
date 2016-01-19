<?php

use Illuminate\Database\Seeder;
use App\Models\Orders\Entities\Order;

class OrdersTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        $faker = Faker\Factory::create();
        $numPrefix = $faker->randomDigit;

        for($i = 0; $i <= 50; $i++){
            $order = new Order();
            $grandTotal = $faker->randomFloat(null, 10.99, 99.99); // 48.8932
            $discount = $grandTotal * 0.2;

            $order->setEmail($faker->email)
                    ->setIncrementId($numPrefix . '0000' . $i)
                    ->setCustomerName($faker->firstName . ' ' . $faker->lastName)
                    ->setQty($faker->numberBetween(0, 10))
                    ->setStatus($faker->randomElement(['Under Review', 'Pending', 'Shipped', 'Closed']))
                    ->setGrandTotal($grandTotal)
                    ->setDiscountAmount($discount)
                    ->setTotalPaid($grandTotal)
                    ->setShippingCountryCode($faker->randomElement(['US', 'CA', 'GBR', 'AU', 'UA']))
                    ->setPaymentMethod($faker->randomElement(['Credit Card', 'PayPal']))
                    ->setCouponCode('NUME' . $faker->randomElement(['HAIR', 'AWSM', 'DISC']))
                    ->setWebsite('nume');

            $order->save();
        }

    }
}

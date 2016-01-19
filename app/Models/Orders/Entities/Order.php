<?php

namespace App\Models\Orders\Entities;

use App\Contracts\DoctrineModel;
use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\ArrayCollection;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;

use App\Contracts\Entities;

/**
 * @ORM\Entity
 * @ORM\Table(name="orders")
 */
class Order extends DoctrineModel{
    use Timestamps;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */

    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $increment_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $status;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $customer_name;

    /**
     * @ORM\Column(type="string", length=32, nullable=false)
     */
    protected $email;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=4, nullable=true)
     */

    protected $grand_total;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=4, nullable=true)
     */

    protected $total_paid;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=4, nullable=true)
     */

    protected $discount_amount;

    /**
     * @ORM\Column(type="string", length=55, nullable=true)
     */

    protected $payment_method;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    protected $shipping_country_code;

    /**
     * @ORM\Column(type="string", length=32, nullable=false)
     */
    protected $coupon_code;

    /**
     * @ORM\Column(type="integer", length=10, nullable=false)
     */
    protected $qty;


    protected $hidden = [];

    /**
     * @return mixed
     */
    public function getIncrementId(){
        return $this->increment_id;
    }

    /**
     * @param mixed $increment_id
     * @return Order
     */
    public function setIncrementId($increment_id){
        $this->increment_id = $increment_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus(){
        return $this->status;
    }

    /**
     * @param mixed $status
     * @return Order
     */
    public function setStatus($status){
        $this->status = $status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCustomerName(){
        return $this->customer_name;
    }

    /**
     * @param mixed $customer_name
     * @return Order
     */
    public function setCustomerName($customer_name){
        $this->customer_name = $customer_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail(){
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return Order
     */
    public function setEmail($email){
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGrandTotal(){
        return $this->grand_total;
    }

    /**
     * @param mixed $grand_total
     * @return Order
     */
    public function setGrandTotal($grand_total){
        $this->grand_total = $grand_total;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTotalPaid(){
        return $this->total_paid;
    }

    /**
     * @param mixed $total_paid
     * @return Order
     */
    public function setTotalPaid($total_paid){
        $this->total_paid = $total_paid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPaymentMethod(){
        return $this->payment_method;
    }

    /**
     * @param mixed $payment_method
     * @return Order
     */
    public function setPaymentMethod($payment_method){
        $this->payment_method = $payment_method;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDiscountAmount(){
        return $this->discount_amount;
    }

    /**
     * @param mixed $discount_amount
     * @return Order
     */
    public function setDiscountAmount($discount_amount){
        $this->discount_amount = $discount_amount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getShippingCountryCode(){
        return $this->shipping_country_code;
    }

    /**
     * @param mixed $shipping_country_code
     * @return Order
     */
    public function setShippingCountryCode($shipping_country_code){
        $this->shipping_country_code = $shipping_country_code;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCouponCode(){
        return $this->coupon_code;
    }

    /**
     * @param mixed $coupon_code
     * @return Order
     */
    public function setCouponCode($coupon_code){
        $this->coupon_code = $coupon_code;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQty(){
        return $this->qty;
    }

    /**
     * @param mixed $qty
     * @return Order
     */
    public function setQty($qty){
        $this->qty = $qty;
        return $this;
    }

}

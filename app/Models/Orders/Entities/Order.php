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
     * @ORM\Column(type="decimal", length=12, precision=4, nullable=true)
     */

    protected $grand_total;

    /**
     * @ORM\Column(type="decimal", length=12, precision=4, nullable=true)
     */

    protected $total_paid;

    /**
     * @ORM\Column(type="string", length=55, nullable=true)
     */

    protected $payment_method;

    /**
     * @ORM\Column(type="decimal", length=12, precision=4, nullable=true)
     */

    protected $discount_amount;

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

}

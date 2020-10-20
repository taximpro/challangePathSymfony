<?php

namespace App\DataFixtures;

use App\Entity\Orders;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OrdersFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {

        for ($i=0;$i<5;$i++){

            $orders = new Orders();
            $orders->setCustomerId(random_int(2, 4));
            $orders->setAddress('Maltepe/Istanbul');
            $orders->setOrderCode(random_int(100, 400));
            $orders->setProductId(random_int(1, 6));
            $orders->setQuantity($i);
            $orders->setShippingDate(date("Y/m/d"));
            $manager->persist($orders);
            $manager->flush();

        }

    }
}

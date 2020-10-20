<?php

namespace App\DataFixtures;

use App\Entity\Orders;
use App\Entity\Products;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i=0;$i<5;$i++){

            $product = new Products();
            $product->setProductName('package'.$i);
            $manager->persist($product);
            $manager->flush();

        }
    }
}

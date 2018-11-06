<?php

namespace App\DataFixtures;

use App\Entity\Topping;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ToppingFixtures extends Fixture{

  public function load(ObjectManager $manager)
  {
    $main = [
      'Pepperonni',
      'Sausage',
      'Ham',
      'Bacon',
      'Beef',
      'Chicken',
    ];
    $secondary = [
      'Mushroom',
      'Olive',
      'Peppers',
      'Onions',
      'Pineapple',
      'Jalapenos',
    ];

    foreach ($main as $item) {
      $topping = new Topping();
      $topping->setName($item);
      $topping->setType('MainTopping');
      $topping->setPrice(500);
      $manager->persist($topping);
    }

    foreach ($secondary as $item) {
      $topping = new Topping();
      $topping->setName($item);
      $topping->setType('SecondaryTopping');
      $topping->setPrice(200);
      $manager->persist($topping);
    }

    $manager->flush();
  }

}

<?php

namespace App\DataFixtures;

use App\Entity\Drink;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class DrinkFixtures extends Fixture{

  public function load(ObjectManager $manager)
  {
    $drinks = [
      [
        'name' => 'Coke',
        'type' => 'Coke',
        'size' => '0,5',
        'price' => 200,
      ],
      [
        'name' => 'Coke',
        'type' => 'Coke',
        'size' => '2',
        'price' => 400,
      ],
      [
        'name' => 'Diet Coke',
        'type' => 'Coke',
        'size' => '0,5',
        'price' => 200,
      ],
      [
        'name' => 'Diet Coke',
        'type' => 'Coke',
        'size' => '2',
        'price' => 400,
      ],
      [
        'name' => 'RedBull',
        'type' => 'Energy',
        'size' => '0,5',
        'price' => 300,
      ],
      [
        'name' => 'RedBull',
        'type' => 'Energy',
        'size' => '2',
        'price' => 500,
      ],
      [
        'name' => 'Monster',
        'type' => 'Energy',
        'size' => '0,5',
        'price' => 300,
      ],
      [
        'name' => 'Monster',
        'type' => 'Energy',
        'size' => '2',
        'price' => 500,
      ],

    ];

    foreach ($drinks as $item) {
      $drink = new Drink();
      $drink->setName($item['name']);
      $drink->setType($item['type']);
      $drink->setSize($item['size']);
      $drink->setPrice($item['price']);
      $manager->persist($drink);
    }

    $manager->flush();
  }

}

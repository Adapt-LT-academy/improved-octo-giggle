<?php

namespace App\DataFixtures;

use App\Entity\Size;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SizeFixtures extends Fixture{

  public function load(ObjectManager $manager)
  {
    $sizes = [
      [
        'name' => 'S',
        'type' => 'S',
        'price' => 200,
      ],
      [
        'name' => 'M',
        'type' => 'M',
        'price' => 400,
      ],
      [
        'name' => 'L',
        'type' => 'L',
        'price' => 800,
      ],
      [
        'name' => 'XL',
        'type' => 'XL',
        'price' => 1000,
      ],
    ];

    foreach ($sizes as $item) {
      $size = new Size();
      $size->setName($item['name']);
      $size->setPrice($item['price']);
      $manager->persist($size);
    }

    $manager->flush();
  }

}

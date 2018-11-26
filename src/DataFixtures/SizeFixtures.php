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
        'type' => 'Size',
        'price' => 200,
      ],
      [
        'name' => 'M',
        'type' => 'Size',
        'price' => 400,
      ],
      [
        'name' => 'L',
        'type' => 'Size',
        'price' => 800,
      ],
      [
        'name' => 'XL',
        'type' => 'Size',
        'price' => 1000,
      ],
    ];

    foreach ($sizes as $item) {
      $size = new Size();
      $size->setName($item['name']);
      $size->setPrice($item['price']);
      $size->setType($item['type']);
      $manager->persist($size);
    }

    $manager->flush();
  }

}

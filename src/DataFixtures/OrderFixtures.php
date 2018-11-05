<?php

namespace App\DataFixtures;

use App\Entity\Drink;
use App\Entity\Item;
use App\Entity\LineItem;
use App\Entity\Order;
use App\Entity\Size;
use App\Entity\Topping;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SebastianBergmann\Diff\Line;

class OrderFixtures extends Fixture implements DependentFixtureInterface{

  /**
   * @var ObjectManager $manager
   */
  private $manager;

  /**
   * @param ObjectManager $manager
   */
  public function load(ObjectManager $manager)
  {
     $this->manager = $manager;
     $order = new Order();

     /**
      * @var Topping $mainTopping
      */
     $mainTopping = $this->getProduct(Topping::class, ['name' => 'Ham']);
     $this->addLineItemToOrder($order, $mainTopping);

     /**
      * @var Topping $secondaryTopping
      */
     $secondaryTopping = $this->getProduct(Topping::class, ['name' => 'Olive']);
     $this->addLineItemToOrder($order, $secondaryTopping);

     /**
      * @var Size $size
      */
     $size = $this->getProduct(Size::class, ['name' => 'M']);
     $this->addLineItemToOrder($order, $size);

     /**
      * @var Drink $drink
      */
     $drink = $this->getProduct(Drink::class, ['name' => 'Coke', 'size' => '2']);
     $this->addLineItemToOrder($order, $drink);

     $drink = $this->getProduct(Drink::class, ['name' => 'RedBull', 'size' => '2']);
     $this->addLineItemToOrder($order, $drink);

     //$order->calculateTotal();
     $manager->persist($order);
     $manager->flush();
  }

  /**
   * @param \App\Entity\Order $order
   * @param \App\Entity\Item  $item
   */
  private function addLineItemToOrder(Order $order, Item $item) {
    $lineItem = new LineItem();
    $lineItem->setSize($item->getSize());
    $lineItem->setType($item->getType());
    $lineItem->setPrice($item->getPrice());
    $lineItem->setName($item->getName());
    $this->manager->persist($lineItem);
    $this->manager->flush();
    $order->addItem($lineItem);
  }

  /**
   * Get product from DB.
   *
   * @param mixed $class
   *   Class to search.
   * @param array $search
   *   Array of search parameters.
   *
   * @return null|object
   */
  private function getProduct($class, array $search = []) {
    $product = $this->manager
      ->getRepository($class)
      ->findOneBy($search)
    ;

    return $product;
  }

  /**
   * This method must return an array of fixtures classes
   * on which the implementing class depends on
   *
   * @return array
   */
  public function getDependencies()
  {
    return array(
      ToppingFixtures::class,
      SizeFixtures::class,
      DrinkFixtures::class,
    );
  }

}

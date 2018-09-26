<?php


namespace App\Tests\integration;

use App\Entity\Drink;
use App\Entity\Order;
use App\Entity\Size;
use App\Entity\Topping;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class OrderTest extends KernelTestCase
{
  /**
   * @var \Doctrine\ORM\EntityManager
   */
  private $entityManager;

  /**
   * {@inheritDoc}
   */
  protected function setUp()
  {
    $kernel = self::bootKernel();

    $this->entityManager = $kernel->getContainer()
      ->get('doctrine')
      ->getManager();
  }

  /**
   * Testing order total calculation.
   */
  public function testOrderTotal()
  {
    /**
     * @var Topping $main
     */
    $main = $this->entityManager
      ->getRepository(Topping::class)
      ->findOneBy(['name' => 'Ham'])
    ;

    /**
     * @var Topping $secondary
     */
    $secondary = $this->entityManager
      ->getRepository(Topping::class)
      ->findOneBy(['name' => 'Olive'])
    ;

    /**
     * @var Size $size
     */
    $size = $this->entityManager
      ->getRepository(Size::class)
      ->findOneBy(['name' => 'M'])
    ;

    /**
     * @var Drink $drink
     */
    $drink = $this->entityManager
      ->getRepository(Drink::class)
      ->findOneBy(['name' => 'Coke', 'size' => '2'])
    ;

    $order = new Order();
    $order->setMainTopping($main);
    $order->setSecondaryTopping($secondary);
    $order->setSize($size);
    $order->setDrink($drink);
    $order->calculateTotal();

    $this->assertEquals(1500, $order->getTotal());
  }

  /**
   * {@inheritDoc}
   */
  protected function tearDown()
  {
    parent::tearDown();

    $this->entityManager->close();
    $this->entityManager = null; // avoid memory leaks
  }
}

<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use SebastianBergmann\Diff\Line;

/**
 * @ORM\Entity
 * @ORM\Table(name="orders")
 */
class Order
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     *
     */
    protected $id;

    /**
     * Many Orders have Many Items.
     * @ORM\ManyToMany(targetEntity="LineItem")
     * @ORM\JoinTable(name="order_line_items",
     *      joinColumns={@ORM\JoinColumn(name="order_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="line_item_id", referencedColumnName="id")}
     *      )
     */
    protected $items;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", length=11)
     */
    protected $total = 0;

    public function __construct() {
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getItems(): ?ArrayCollection
    {
      return $this->items;
    }

    /**
     * @param LineItem $item
     *
     * @return $this
     */
    public function addItem(LineItem $item): self
    {
      $this->items[] = $item;

      return $this;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @param int $total
     *
     * @return $this
     */
    public function setTotal(int $total): self
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Calculate and set order total using it's products.
     */
    public function calculateTotal() {
//      $mainTopping = $this->getMainTopping();
//      $secondaryTopping = $this->getSecondaryTopping();
//      $size = $this->getSize();
//      $drinks = $this->getDrinks();
//      $drinkPrices = 0;
//      foreach ($drinks as $drink) {
//          $drinkPrices += $drink->getPrice();
//      }
//
//      $toppings = bcadd($mainTopping->getPrice(), $secondaryTopping->getPrice());
//      $misc = bcadd($size->getPrice(), $drinkPrices);
//      $total = bcadd($toppings, $misc);
//
//      $this->setTotal($total);
    }

}

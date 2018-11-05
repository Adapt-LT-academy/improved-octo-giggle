<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Drink extends Item
{
        /**
     * @var string
     *
     * @ORM\Column(type="string", length=20)
     */
    protected $size = '';

    /**
     * @return string
     */
    public function getSize(): string
    {
      return $this->size;
    }

    /**
     * @param string $size
     *
     * @return $this
     */
    public function setSize(string $size): self
    {
      $this->size = $size;

      return $this;
    }

}

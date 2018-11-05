<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class LineItem extends Item
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $attributes = '';

    /**
     * @return string
     */
    public function getAttributes(): string
    {
        return $this->attributes;
    }

    /**
     * @param string $attributes
     *
     * @return $this
     */
    public function setAttributes(string $attributes): self
    {
        $this->attributes = $attributes;

        return $this;
    }

}

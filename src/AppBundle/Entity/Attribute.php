<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping\Column;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @Attribute
 * @UniqueEntity("name")
 */
class Attribute {

    /**
     * @var string
     * @Assert\NotBlank()
     * @Column(name="name", type="string", length=255,nullable=true)
     */
    protected $name;

    /**
     * Set name
     *
     * @param string $name
     * @return Criteria
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

}

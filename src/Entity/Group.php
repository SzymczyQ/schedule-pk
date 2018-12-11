<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     name="groups",
 * )
 * @ORM\Entity(repositoryClass="App\Repository\GroupRepository")
 */
class Group
{
    /**
     * @var integer|null $id
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Many Groups have one Year. This is the owning side.
     *
     * @var Year|null $year
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Year", inversedBy="groups")
     * @ORM\JoinColumn(name="year_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $year;

    /**
     * @var string|null $name
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=true)
     */
    private $name;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return Year|null
     */
    public function getYear(): ?Year
    {
        return $this->year;
    }

    /**
     * @param Year|null $year
     */
    public function setYear(?Year $year): void
    {
        $this->year = $year;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param null|string $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }
}
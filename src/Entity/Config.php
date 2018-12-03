<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Table(
 *     name="config",
 *     uniqueConstraints={
 *          @ORM\UniqueConstraint(name="unique_token", columns={"token"})
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\ConfigRepository")
 */
class Config
{
    use TimestampableEntity;

    /**
     * @var integer|null $id
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string|null $token
     *
     * @ORM\Column(name="token", type="string", length=255, nullable=false)
     */
    private $token;

    /**
     * @var string|null $value
     *
     * @ORM\Column(name="value", type="text")
     */
    private $value;

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
     * @return null|string
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @param null|string $token
     */
    public function setToken(?string $token): void
    {
        $this->token = $token;
    }

    /**
     * @return null|string
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @param null|string $value
     */
    public function setValue(?string $value): void
    {
        $this->value = $value;
    }
}
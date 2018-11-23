<?php

namespace App\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Class User
 * @package App\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    use TimestampableEntity;

    /**
     * @var int|null
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", name="google_id", length=255, nullable=true)
     */
    protected $googleId;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return null|string
     */
    public function getGoogleId(): ?string
    {
        return $this->googleId;
    }

    /**
     * @param null|string $googleId
     */
    public function setGoogleId(?string $googleId): void
    {
        $this->googleId = $googleId;
    }
}

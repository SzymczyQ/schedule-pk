<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Class User
 * @package App\Entity
 *
 * @ORM\Entity
 * @ORM\Table(
 *     name="user",
 *     uniqueConstraints={
 *          @ORM\UniqueConstraint(name="unique_index_google_id", columns={"google_id"})
 *     },
 * )
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
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
     * One User has many UserSchoolInfos. This is the inverse side.
     *
     * @var UserSchoolInfo[]|null $userSchoolInfos
     *
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\UserSchoolInfo",
     *     mappedBy="user",
     *     cascade={"persist", "remove"},
     *     orphanRemoval=TRUE
     * )
     */
    private $userSchoolInfos;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", name="first_name", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", name="last_name", length=255, nullable=true)
     */
    private $lastName;

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

        $this->userSchoolInfos = new ArrayCollection();
    }

    /**
     * @return Collection|null
     */
    public function getUserSchoolInfos(): ?Collection
    {
        return $this->userSchoolInfos;
    }

    /**
     * @param Collection|null $userSchoolInfos
     */
    public function setUserSchoolInfos(?Collection $userSchoolInfos): void
    {
        $this->userSchoolInfos = $userSchoolInfos;
    }

    /**
     * @param UserSchoolInfo $userSchoolInfo
     */
    public function addUserSchoolInfo(UserSchoolInfo $userSchoolInfo): void
    {
        if (!$this->userSchoolInfos->contains($userSchoolInfo)) {
            $this->userSchoolInfos->add($userSchoolInfo);
            $userSchoolInfo->setUser($this);
        }
    }

    /**
     * @param UserSchoolInfo $userSchoolInfo
     */
    public function removeUserSchoolInfo(UserSchoolInfo $userSchoolInfo): void
    {
        if ($this->userSchoolInfos->contains($userSchoolInfo)) {
            $this->userSchoolInfos->removeElement($userSchoolInfo);
            $userSchoolInfo->setUser(null);
        }
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

    /**
     * @return null|string
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param null|string $firstName
     */
    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return null|string
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param null|string $lastName
     */
    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }
}

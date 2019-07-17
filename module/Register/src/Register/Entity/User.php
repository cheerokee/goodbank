<?php

namespace Register\Entity;

use Acl\Entity\Role;
use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;
use Doctrine\Common\Collections\Collection;
/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="Register\Entity\UserRepository")
 */
class User
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="document", type="string", length=255, nullable=true)
     */
    private $document;

    /**
     * @var \Register\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Register\Entity\User",
     *      inversedBy="sponsor", fetch="LAZY")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sponsor", referencedColumnName="id",
     *      nullable=true,
     *      onDelete="SET NULL")
     * })
     */
    private $sponsor;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="celphone", type="string", length=255, nullable=true)
     */
    private $celphone;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthdate", type="datetime", nullable=true)
     */
    private $birthdate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="gender", type="boolean", nullable=true)
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255, nullable=true)
     */
    private $salt;

    /**
     * @var string
     *
     * @ORM\Column(name="activation_key", type="string", length=255, nullable=true)
     */
    private $activationKey;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $created_at;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\OneToMany(targetEntity="Register\Entity\UserRole",
     *      cascade={"persist", "remove","merge","refresh"},
     *      mappedBy="user", orphanRemoval=true)
     */
    private $user_roles;

    /**
     * @var string
     *
     * @ORM\Column(name="friendly_url", type="string", length=255, nullable=true)
     */
    private $friendlyUrl;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    public function __construct(array $options = array())
    {
        (new Hydrator\ClassMethods)->hydrate($options, $this);

        $this->created_at = new \DateTime("now");
        $this->updated_at = new \DateTime("now");

        //$this->activationKey = md5($this->email);
        $this->activationKey = md5(time());
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $this->encryptPassword($password);
        return $this;
    }

    public function encryptPassword($password)
    {
        return md5($password);
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function setSalt($salt)
    {
        $this->salt = $salt;
        return $this;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    public function getActivationKey()
    {
        return $this->activationKey;
    }

    public function setActivationKey($activationKey)
    {
        $this->activationKey = $activationKey;
        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    public function setUpdatedAt()
    {
        $this->updated_at = new \DateTime("now");
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setCreatedAt()
    {
        $this->created_at = new \DateTime("now");
    }

    public function toArray()
    {
        return (new Hydrator\ClassMethods())->extract($this);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * @param string $document
     */
    public function setDocument($document)
    {
        $this->document = $document;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getCelphone()
    {
        return $this->celphone;
    }

    /**
     * @param string $celphone
     */
    public function setCelphone($celphone)
    {
        $this->celphone = $celphone;
    }

    /**
     * @return Collection
     */
    public function getUserRoles()
    {
        return $this->user_roles;
    }

    /**
     * @param Collection $user_roles
     */
    public function setUserRoles($user_roles)
    {
        $this->user_roles = $user_roles;
    }

    public function hasThisRole($role) {
        /**
         * @var UserRole[] $userRoles
         * @var Role $db_role
         */
        $userRoles = $this->getUserRoles()->getValues();

        if(!empty($userRoles))
        {
            foreach($userRoles as $userRole)
            {
                $db_role = $userRole->getRole();

                if($db_role->getFriendlyUrl() == $role || $db_role->getName() == $role)
                {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @return string
     */
    public function getFriendlyUrl()
    {
        return $this->friendlyUrl;
    }

    /**
     * @param string $friendly_url
     */
    public function setFriendlyUrl($friendlyUrl)
    {
        $this->friendlyUrl = $friendlyUrl;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return User
     */
    public function getSponsor()
    {
        return $this->sponsor;
    }

    /**
     * @param User $sponsor
     */
    public function setSponsor($sponsor)
    {
        $this->sponsor = $sponsor;
    }

    /**
     * @return \DateTime
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * @param \DateTime $birthdate
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
    }

    /**
     * @return bool
     */
    public function isGender()
    {
        return $this->gender;
    }

    /**
     * @param bool $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }
}

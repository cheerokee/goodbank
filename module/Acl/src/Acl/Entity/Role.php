<?php
namespace Acl\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="roles")
 * @ORM\ENtity(repositoryClass="Acl\Entity\RoleRepository")
 */

class Role
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="Acl\Entity\Role")
     * @ORM\JoinColumn(name="parent_id",referencedColumnName="id")
     */
    protected $parent;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    protected $name;

    /**
     * @ORM\Column(type="boolean",name="is_admin",nullable=true)
     * @var boolean
     */
    protected $isAdmin;

    /**
     * @ORM\Column(type="datetime",name="created_at")
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime",name="updated_at")
     */
    protected $updatedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="friendly_url", type="string", length=255, nullable=true)
     */
    private $friendlyUrl;

    public function __construct($options = array())
    {
        //(new Hydrator\ClassMethods)->hydrate($options,this);
        $this->createdAt = new \DateTime("now");
        $this->updatedAt = new \DateTime("now");
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    public function getParentName()
    {
        if($this->parent){
            return $this->parent->getName();
        }else{
            return null;
        }

    }


    /**
     * @param mixed $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsAdmin()
    {
        return $this->isAdmin;
    }

    public function isIsAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * @return mixed
     */
    public function isAdmin()
    {
        return $this->isAdmin;
    }

    public function getIsAdminStr()
    {
        return ($this->isAdmin)?'Sim':'Não';
    }

    /**
     * @param mixed $isAdmin
     */
    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt()
    {
        $this->createdAt = new \DateTime('now');
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Antes de Persistir no banco
     * @ORM\PrePersist
     */
    public function setUpdatedAt()
    {
        $this->updatedAt = new \DateTime('now');
        return $this;
    }

    /**
     * @return string
     */
    public function getFriendlyUrl()
    {
        return $this->friendlyUrl;
    }

    /**
     * @param string $friendlyUrl
     */
    public function setFriendlyUrl($friendlyUrl)
    {
        $this->friendlyUrl = $friendlyUrl;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function __toArray()
    {
        if(isset($this->parent))
            $parent = $this->parent->getId();
        else
            $parent = false;

        return array(
            'id'        =>  $this->id,
            'name'      =>  $this->name,
            'isAdmin'   =>  $this->isAdmin,
            'parent'    =>  $parent
        );

    }
}

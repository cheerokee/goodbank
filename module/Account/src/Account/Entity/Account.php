<?php
namespace Account\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BankAccount
 *
 * @ORM\Table(name="account")
 * @ORM\Entity(repositoryClass="Account\Entity\AccountRepository")
 */
class Account
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
     * @var \Bank\Entity\Bank
     *
     * @ORM\ManyToOne(targetEntity="Bank\Entity\Bank")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="bank_id", referencedColumnName="id",
     *      nullable=false,
     *      onDelete="CASCADE")
     * })
     */
    private $bank;

    /**
     * @var \Register\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Register\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id",
     *      nullable=false,
     *      onDelete="CASCADE")
     * })
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="holder", type="string", length=255, nullable=false)
     */
    private $holder;

    /**
     * @var string
     *
     * @ORM\Column(name="agency", type="string", length=255, nullable=false)
     */
    private $agency;

    /**
     * @var string
     *
     * @ORM\Column(name="account_number", type="string", length=255, nullable=false)
     */
    private $account_number;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="boolean", nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="operation", type="string", length=255, nullable=true)
     */
    private $operation;

    /**
     * @var string
     *
     * @ORM\Column(name="type_account", type="boolean", nullable=false)
     */
    private $type_account;

    /**
     * @var string
     *
     * @ORM\Column(name="main", type="boolean", nullable=false)
     */
    private $main;

    /**
     * @var string
     *
     * @ORM\Column(name="cnpj", type="string", length=255, nullable=true)
     */
    private $cnpj;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updated_at;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $created_at;

    public function __construct(array $options = array())
    {
        $this->created_at = new \DateTime("now");
        $this->updated_at = new \DateTime("now");
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
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param \DateTime $updated_at
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param \DateTime $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return \Bank\Entity\Bank
     */
    public function getBank()
    {
        return $this->bank;
    }

    /**
     * @param \Bank\Entity\Bank $bank
     */
    public function setBank($bank)
    {
        $this->bank = $bank;
    }

    /**
     * @return \Register\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param \Register\Entity\User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getHolder()
    {
        return $this->holder;
    }

    /**
     * @param string $holder
     */
    public function setHolder($holder)
    {
        $this->holder = $holder;
    }

    /**
     * @return string
     */
    public function getAgency()
    {
        return $this->agency;
    }

    /**
     * @param string $agency
     */
    public function setAgency($agency)
    {
        $this->agency = $agency;
    }

    /**
     * @return string
     */
    public function getAccountNumber()
    {
        return $this->account_number;
    }

    /**
     * @param string $account_number
     */
    public function setAccountNumber($account_number)
    {
        $this->account_number = $account_number;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * @param string $operation
     */
    public function setOperation($operation)
    {
        $this->operation = $operation;
    }

    /**
     * @return string
     */
    public function getTypeAccount()
    {
        return $this->type_account;
    }

    /**
     * @param string $type_account
     */
    public function setTypeAccount($type_account)
    {
        $this->type_account = $type_account;
    }

    /**
     * @return string
     */
    public function getCnpj()
    {
        return $this->cnpj;
    }

    /**
     * @param string $cnpj
     */
    public function setCnpj($cnpj)
    {
        $this->cnpj = $cnpj;
    }

    public function getName(){
        return $this->getBank()->getName().' '.$this->getAgency().' '.$this->getAccountNumber();
    }

    /**
     * @return string
     */
    public function getMain()
    {
        return $this->main;
    }

    public function getMainStr()
    {
        return ($this->main) ? "Sim" : "Não";
    }

    /**
     * @param string $main
     */
    public function setMain($main)
    {
        $this->main = $main;
    }
}


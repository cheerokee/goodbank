<?php
namespace Transaction\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BankAccount
 *
 * @ORM\Table(name="transaction")
 * @ORM\Entity(repositoryClass="Transaction\Entity\TransactionRepository")
 */
class Transaction
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
     * @var \UserPlan\Entity\UserPlan
     *
     * @ORM\ManyToOne(targetEntity="UserPlan\Entity\UserPlan")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_plan_id", referencedColumnName="id",
     *      nullable=true,
     *      onDelete="SET NULL")
     * })
     */
    private $user_plan;

    /**
     * @var \Cycle\Entity\Cycle
     *
     * @ORM\ManyToOne(targetEntity="Cycle\Entity\Cycle")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cycle_id", referencedColumnName="id",
     *      nullable=true,
     *      onDelete="SET NULL")
     * })
     */
    private $cycle;

    /**
     * @var \CategoryTransaction\Entity\CategoryTransaction
     *
     * @ORM\ManyToOne(targetEntity="CategoryTransaction\Entity\CategoryTransaction")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_transaction_id", referencedColumnName="id",
     *      nullable=true,
     *      onDelete="SET NULL")
     * })
     */
    private $category_transaction;

    /**
     * @var \Transaction\Entity\Transaction
     *
     * @ORM\ManyToOne(targetEntity="Transaction\Entity\Transaction")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="transaction_id", referencedColumnName="id",
     *      nullable=true,
     *      onDelete="SET NULL")
     * })
     */
    private $transaction_reference;

    /**
     * @var string
     * 0 - Crédito
     * 1 - Débito
     * @ORM\Column(name="type", type="boolean", nullable=false)
     */
    private $type;

    /**
     * @var string
     * @ORM\Column(name="value", type="float", nullable=false)
     */
    private $value;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

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
     * @return \UserPlan\Entity\UserPlan
     */
    public function getUserPlan()
    {
        return $this->user_plan;
    }

    /**
     * @param \UserPlan\Entity\UserPlan $user_plan
     */
    public function setUserPlan($user_plan)
    {
        $this->user_plan = $user_plan;
    }

    /**
     * @return \Cycle\Entity\Cycle
     */
    public function getCycle()
    {
        return $this->cycle;
    }

    /**
     * @param \Cycle\Entity\Cycle $cycle
     */
    public function setCycle($cycle)
    {
        $this->cycle = $cycle;
    }

    /**
     * @return \CategoryTransaction\Entity\CategoryTransaction
     */
    public function getCategoryTransaction()
    {
        return $this->category_transaction;
    }

    /**
     * @param \CategoryTransaction\Entity\CategoryTransaction $category_transaction
     */
    public function setCategoryTransaction($category_transaction)
    {
        $this->category_transaction = $category_transaction;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    public function getTypeStr()
    {
        return ($this->type)?'Débito':'Crédito';
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
    public function getValue()
    {
        return $this->value;
    }

    public function getValueStr()
    {
        return 'R$ ' . number_format($this->value, 2, ',', '.');
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    public function getDateStr()
    {
        return $this->date->format('d/m/Y H:i:s');
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
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
     * @return Transaction
     */
    public function getTransactionReference()
    {
        return $this->transaction_reference;
    }

    /**
     * @param Transaction $transaction_reference
     */
    public function setTransactionReference($transaction_reference)
    {
        $this->transaction_reference = $transaction_reference;
    }

    public function __toString()
    {
        return "Plano: " . $this->getUserPlan() . " / Usuário: " . $this->getValueStr();
    }
}


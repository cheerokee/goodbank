<?php
namespace UserPlan\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BankAccount
 *
 * @ORM\Table(name="user_plan")
 * @ORM\Entity(repositoryClass="UserPlan\Entity\UserPlanRepository")
 */
class UserPlan
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
     * @var \Plan\Entity\Plan
     *
     * @ORM\ManyToOne(targetEntity="Plan\Entity\Plan")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="plan_id", referencedColumnName="id",
     *      nullable=true,
     *      onDelete="SET NULL")
     * })
     */
    private $plan;

    /**
     * @var \PaymentMethod\Entity\PaymentMethod
     *
     * @ORM\ManyToOne(targetEntity="PaymentMethod\Entity\PaymentMethod")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="payment_method_id", referencedColumnName="id",
     *      nullable=true,
     *      onDelete="SET NULL")
     * })
     */
    private $payment_method;

    /**
     * @var \Wallet\Entity\Wallet
     *
     * @ORM\ManyToOne(targetEntity="Wallet\Entity\Wallet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="wallet_id", referencedColumnName="id",
     *      nullable=true,
     *      onDelete="SET NULL")
     * })
     */
    private $wallet;

    /**
     * @var \Account\Entity\Account
     *
     * @ORM\ManyToOne(targetEntity="Account\Entity\Account")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="account_id", referencedColumnName="id",
     *      nullable=true,
     *      onDelete="SET NULL")
     * })
     */
    private $account;

    /**
     * @var \Cycle\Entity\Cycle
     *
     * @ORM\ManyToOne(targetEntity="Cycle\Entity\Cycle")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="first_cycle", referencedColumnName="id",
     *      nullable=true,
     *      onDelete="SET NULL")
     * })
     */
    private $first_cycle;

    /**
     * @var string
     *
     * @ORM\Column(name="receipt", type="string", length=255, nullable=true)
     */
    private $receipt;

    /**
     * @var string
     * 0 - Inativo
     * 1 - Ativo
     * 2 - Resgate Solicitado
     * 3 - Resgatado
     * 4 - Cancelado
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="approved_date", type="datetime", nullable=true)
     */
    private $approved_date;

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
     * @return \Plan\Entity\Plan
     */
    public function getPlan()
    {
        return $this->plan;
    }

    /**
     * @param \Plan\Entity\Plan $plan
     */
    public function setPlan($plan)
    {
        $this->plan = $plan;
    }

    /**
     * @return \PaymentMethod\Entity\PaymentMethod
     */
    public function getPaymentMethod()
    {
        return $this->payment_method;
    }

    /**
     * @param \PaymentMethod\Entity\PaymentMethod $payment_method
     */
    public function setPaymentMethod($payment_method)
    {
        $this->payment_method = $payment_method;
    }

    /**
     * @return \Wallet\Entity\Wallet
     */
    public function getWallet()
    {
        return $this->wallet;
    }

    /**
     * @param \Wallet\Entity\Wallet $wallet
     */
    public function setWallet($wallet)
    {
        $this->wallet = $wallet;
    }

    /**
     * @return \Account\Entity\Account
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @param \Account\Entity\Account $account
     */
    public function setAccount($account)
    {
        $this->account = $account;
    }

    /**
     * @return \Cycle\Entity\Cycle
     */
    public function getFirstCycle()
    {
        return $this->first_cycle;
    }

    /**
     * @param \Cycle\Entity\Cycle $first_cycle
     */
    public function setFirstCycle($first_cycle)
    {
        $this->first_cycle = $first_cycle;
    }

    /**
     * @return string
     */
    public function getReceipt()
    {
        return $this->receipt;
    }

    /**
     * @param string $receipt
     */
    public function setReceipt($receipt)
    {
        $this->receipt = $receipt;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    public function getStatusStr()
    {
        $status = '';

        switch ($this->status){
            case 0:
                $status = 'Inativo';
                break;
            case 1:
                $status = 'Ativo';
                break;
            case 2:
                $status = 'Resgate Solicitado';
                break;
            case 3:
                $status = 'Resgatado';
                break;
            case 4:
                $status = 'Cancelado';
                break;
            default:
                $status = 'Status não definido';
        }
        return $status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getName(){
        return "Código: " . $this->getId() . " Plano: " . $this->getPlan()->getName() . " / Usuário: " . $this->getUser()->getName();
    }

    public function __toString()
    {
        return "Código: " . $this->getId() . " Plano: " . $this->getPlan()->getName() . " / Usuário: " . $this->getUser()->getName();
    }

    /**
     * @return \DateTime
     */
    public function getApprovedDate()
    {
        return $this->approved_date;
    }

    public function getApprovedDateStr()
    {
        return ($this->approved_date != null)?$this->approved_date->format('d/m/Y H:i:s'):'Não Aprovado';
    }

    public function getExpirationDateStr()
    {
        $date = $this->approved_date->format('Y-m-d H:i:s');
        $date_expiration = date('d/m/Y H:i:s', strtotime("+1 year",strtotime($date)));

        return ($this->approved_date != null)?$date_expiration:'Não Aprovado';
    }

    public function getExpirationDate()
    {
        $date = $this->approved_date->format('Y-m-d H:i:s');
        $date_expiration = date('Y-m-d H:i:s', strtotime("+1 year",strtotime($date)));

        return ($this->approved_date != null)?(new \DateTime($date_expiration)):'Não Aprovado';
    }

    public function getDaysRemainingStr()
    {
        $data_inicial = new \DateTime('now');
        $data_final = $this->getExpirationDate();
        $diferenca = $data_inicial->diff( $data_final );

        return $diferenca->days;
    }

    /**
     * @param \DateTime $approved_date
     */
    public function setApprovedDate($approved_date)
    {
        $this->approved_date = $approved_date;
    }
}


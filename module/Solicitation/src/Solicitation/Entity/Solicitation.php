<?php
namespace Solicitation\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BankAccount
 *
 * @ORM\Table(name="solicitation")
 * @ORM\Entity(repositoryClass="Solicitation\Entity\SolicitationRepository")
 */
class Solicitation
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
     * 0 - Saque
     * 1 - Renovação
     * 2 - Resgate
     * 3 - Primeira Comissão
     * 4 - Comissão
     * @ORM\Column(name="type", type="integer", nullable=false)
     */
    private $type;

    /**
     * Método de recebimento
     * @var string
     * 0 - Conta Bancária
     * 1 - Bitcoin
     * @ORM\Column(name="receive_method", type="integer", nullable=true)
     */
    private $receive_method;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="float", nullable=false)
     */
    private $value;

    /**
     * @var \UserPlan\Entity\UserPlan
     *
     * @ORM\ManyToOne(targetEntity="UserPlan\Entity\UserPlan")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_plan_id", referencedColumnName="id",
     *      nullable=false,
     *      onDelete="CASCADE")
     * })
     */
    private $user_plan;

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
     * @ORM\Column(name="closed", type="boolean", nullable=true)
     */
    private $closed;

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

    public function getCreatedAtStr()
    {
        return $this->created_at->format('d/m/Y H:i:s');
    }

    /**
     * @param \DateTime $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
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
        $str = '';

        switch ($this->type)
        {
            case 0:
                $str = 'Saque';
                break;
            case 1:
                $str = 'Renovação';
                break;
            case 2:
                $str = 'Resgate';
                break;
            case 3:
                $str = 'Primeira Comissão';
                break;
            case 4:
                $str = 'Comissão';
                break;
        }

        return $str;
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
     * @return string
     */
    public function getClosed()
    {
        return $this->closed;
    }

    public function getClosedStr()
    {
        return ($this->closed)?'<span class="g-color-green">Sim</span>' : '<span class="g-color-red">Não</span>';
    }

    /**
     * @param string $closed
     */
    public function setClosed($closed)
    {
        $this->closed = $closed;
    }

    /**
     * @return string
     */
    public function getReceiveMethod()
    {
        return $this->receive_method;
    }

    public function getReceiveMethodStr()
    {
        return ($this->receive_method) ? "Carteira Bitcoin" : "Conta Bancária";
    }

    /**
     * @param string $receive_method
     */
    public function setReceiveMethod($receive_method)
    {
        $this->receive_method = $receive_method;
    }

    public function __toString()
    {
        return "Solicitação de " . $this->getTypeStr() . " para o aporte " . $this->getUserPlan();
    }
}


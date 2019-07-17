<?php
namespace PercentGain\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BankAccount
 *
 * @ORM\Table(name="percent_gain")
 * @ORM\Entity(repositoryClass="PercentGain\Entity\PercentGainRepository")
 */
class PercentGain
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
     * @ORM\Column(name="value_start", type="float", nullable=true)
     */
    private $value_start;

    /**
     * @var string
     *
     * @ORM\Column(name="value_finish", type="float", nullable=false)
     */
    private $value_finish;

    /**
     * @var string
     *
     * @ORM\Column(name="percent", type="float", nullable=false)
     */
    private $percent;

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
     * @return string
     */
    public function getValueStart()
    {
        return $this->value_start;
    }

    public function getValueStartStr()
    {
        $value = ($this->value_start)?$this->value_start:0;
        $value = 'R$' . number_format($value, 2, ',', '.');
        return $value;
    }

    /**
     * @param string $value_start
     */
    public function setValueStart($value_start)
    {
        $this->value_start = $value_start;
    }

    /**
     * @return string
     */
    public function getValueFinish()
    {
        return $this->value_finish;
    }

    public function getValueFinishStr()
    {
        $value = ($this->value_finish)?$this->value_finish:0;
        $value = 'R$' . number_format($value, 2, ',', '.');
        return $value;
    }

    /**
     * @param string $value_finish
     */
    public function setValueFinish($value_finish)
    {
        $this->value_finish = $value_finish;
    }

    /**
     * @return string
     */
    public function getPercent()
    {
        return $this->percent;
    }

    public function getPercentStr()
    {
        $value = ($this->percent)?$this->percent:0;
        $value = number_format($value, 2, ',', '.') . '%';
        return $value;
    }

    /**
     * @param string $percent
     */
    public function setPercent($percent)
    {
        $this->percent = $percent;
    }

    public function __toString()
    {
        $value_start = 'R$' . number_format($this->getValueStart(), 2, ',', '.');
        $value_finish = 'R$' . number_format($this->getValueFinish(), 2, ',', '.');
        $percent = number_format($this->getPercent(), 2, ',', '.');
        return "Valores de " . $value_start . " até " . $value_finish . ", tem um percetual de ganho de " . $percent . "%";
    }
}


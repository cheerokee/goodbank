<?php

namespace PercentGain\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

class PercentGainRepository extends EntityRepository
{
    public function findOneByInterval($value){
        $alias = 'x';
        $tabela = 'PercentGain\Entity\PercentGain';

        $where = "x.value_start <= ".$value." AND  x.value_finish >= ".$value;

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select(array(
            $alias
        ))
            ->from($tabela,$alias)
            ->where($where)
            ->orderBy('x.created_at','DESC');

        if(!empty($qb->getQuery()->getResult())){
            return $qb->getQuery()->getResult()[0];
        }else{
            return array();
        }
    }
}

<?php

namespace Address\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

class StateRepository extends EntityRepository
{
    public function findOneByLike($name)
    {
        $alias = 'x';
        $tabela = 'Address\Entity\State';
        if($name != ''){
            $where = "x.uf LIKE '%".$name."%'";
        }else{
            $where = "1=1";
        }


        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select(array(
            $alias
        ))
            ->from($tabela,$alias)
            ->where($where);

        if(!empty($qb->getQuery()->getResult())){
            return $qb->getQuery()->getResult()[0];
        }else{
            return array();
        }
    }
}

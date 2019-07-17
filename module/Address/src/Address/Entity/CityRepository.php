<?php

namespace Address\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

class CityRepository extends EntityRepository
{
    public function findOneByLike($name,$state_id)
    {
        $alias = 'x';
        $tabela = 'Address\Entity\City';
        if($name != ''){
            $where = "x.name LIKE '%".$name."%' AND x.state = ".$state_id;
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

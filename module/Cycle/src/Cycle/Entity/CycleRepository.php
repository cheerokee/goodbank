<?php

namespace Cycle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

class CycleRepository extends EntityRepository
{
    public function findByFilter($data){

        $alias = 'x';
        $tabela = 'Cycle\Entity\Cycle';

        $where = "1=1";

        if(isset($data['cycle_month']) && $data['cycle_month'] != ''){
            $where .= " AND x.month = " . $data['cycle_month'];
        }

        if(isset($data['cycle_year']) && $data['cycle_year'] != ''){
            $where .= " AND x.year = " . $data['cycle_year'];
        }

        if(isset($data['cycle_status']) && $data['cycle_status'] != -1 && $data['cycle_status'] !== ''){
            $where .= " AND x.status = " . $data['cycle_status'];
        }

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select(array(
            $alias
        ))
            ->from($tabela,$alias)
            ->where($where);



        if(!empty($qb->getQuery()->getResult())){
            return $qb->getQuery()->getResult();
        }else{
            return array();
        }
    }
}

<?php

namespace Transaction\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

class TransactionRepository extends EntityRepository
{
    public function findByFilter($data){

        $alias = 'x';
        $tabela = 'Transaction\Entity\Transaction';

        $where = "1=1";

        if(isset($data['transaction_user_id']) && $data['transaction_user_id'] != ''){
            $where .= " AND x.user = " . $data['transaction_user_id'];
        }

        if(isset($data['transaction_user_plan_id']) && $data['transaction_user_plan_id'] != ''){
            $where .= " AND x.user_plan = " . $data['transaction_user_plan_id'];
        }

        if(isset($data['transaction_cycle_id']) && $data['transaction_cycle_id'] != ''){
            $where .= " AND x.cycle = " . $data['transaction_cycle_id'];
        }

        if(isset($data['transaction_category_transaction']) && $data['transaction_category_transaction'] != ''){
            $where .= " AND x.category_transaction = " . $data['transaction_category_transaction'];
        }

        if(isset($data['transaction_type']) && $data['transaction_type'] != ''){
            $where .= " AND x.type = " . $data['transaction_type'];
        }


        if(isset($data['transaction_date_de']) && $data['transaction_date_de'] != ''){
            $where .= " AND x.date >= '" . str_replace('T',' ',$data['transaction_date_de'])."'";
        }

        if(isset($data['transaction_date_ate']) && $data['transaction_date_ate'] != ''){
            $where .= " AND x.date <= '" . str_replace('T',' ',$data['transaction_date_ate']) . "'";
        }

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select(array(
            $alias
        ))
            ->from($tabela,$alias)
            ->where($where)
            ->orderBy('x.created_at','DESC');

        if(!empty($qb->getQuery()->getResult())){
            return $qb->getQuery()->getResult();
        }else{
            return array();
        }
    }

    public function findByUser($user_id){

        $alias = 'x';
        $tabela = 'Transaction\Entity\Transaction';

        $where = "x.user = $user_id";

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

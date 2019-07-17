<?php

namespace UserPlan\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

class UserPlanRepository extends EntityRepository
{
    public function findByFilter($data){

        $alias = 'x';
        $tabela = 'UserPlan\Entity\UserPlan';

        $where = "1=1";

        if(isset($data['user-plan_user_id']) && $data['user-plan_user_id'] != ''){
            $where .= " AND x.user = " . $data['user-plan_user_id'];
        }

        if(isset($data['user-plan_account']) && $data['user-plan_account'] != ''){
            $where .= " AND x.account = " . $data['user-plan_account'];
        }

        if(isset($data['user-plan_plan']) && $data['user-plan_plan'] != ''){
            $where .= " AND x.plan = " . $data['user-plan_plan'];
        }

        if(isset($data['user-plan_payment-method']) && $data['user-plan_payment-method'] != ''){
            $where .= " AND x.payment_method = " . $data['user-plan_payment-method'];
        }


        if(isset($data['user-plan_wallet_id']) && $data['user-plan_wallet_id'] != ''){
            $where .= " AND x.wallet = " . $data['user-plan_wallet_id'];
        }

        if(isset($data['user-plan_first-access']) && $data['user-plan_first-access'] != ''){
            $where .= " AND x.firstAccess = " . $data['user-plan_first-access'];
        }

        if(isset($data['user-plan_status']) && $data['user-plan_status'] != -1 && $data['user-plan_status'] !== ''){
            $where .= " AND x.status = " . $data['user-plan_status'];
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

    public function findByIds($ids){
        $alias = 'x';
        $tabela = 'UserPlan\Entity\UserPlan';

        $where = "x.id IN (" . $ids . ")";

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
}

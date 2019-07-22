<?php

namespace Solicitation\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

class SolicitationRepository extends EntityRepository
{
    public function findByFilter($data){

        $alias = 'x';
        $tabela = 'Solicitation\Entity\Solicitation';

        $where = "1=1";

        if(isset($data['solicitation_user_plan_id']) && $data['solicitation_user_plan_id'] != ''){
            $where .= " AND x.user_plan = " . $data['solicitation_user_plan_id'];
        }

        if(isset($data['solicitation_user_id']) && $data['solicitation_user_id'] != ''){
            $where .= " AND x.user = " . $data['solicitation_user_id'];
        }

        if(isset($data['solicitation_type']) && $data['solicitation_type'] != ''){
            $where .= " AND x.type = " . $data['solicitation_type'];
        }

        if(isset($data['solicitation_closed']) && $data['solicitation_closed'] != ''){
            $where .= " AND x.closed = " . $data['solicitation_closed'];
        }

        if(isset($data['solicitation_created_at_de']) && $data['solicitation_created_at_de'] != ''){
            $where .= " AND x.created_at >= '" . str_replace('T',' ',$data['solicitation_created_at_de'])."'";
        }

        if(isset($data['solicitation_created_at_ate']) && $data['solicitation_created_at_ate'] != ''){
            $where .= " AND x.created_at <= '" . str_replace('T',' ',$data['solicitation_created_at_ate']) . "'";
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
}

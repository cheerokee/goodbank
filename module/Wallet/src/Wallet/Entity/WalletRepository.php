<?php

namespace Wallet\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

class WalletRepository extends EntityRepository
{
    public function findByFilter($data){

        $alias = 'x';
        $tabela = 'Wallet\Entity\Wallet';

        $where = "1=1";

        if(isset($data['wallet_user_id']) && $data['wallet_user_id'] != ''){
            $where .= " AND x.user = " . $data['wallet_user_id'];
        }

        if(isset($data['wallet_account']) && $data['wallet_account'] != ''){
            $where .= " AND x.account = " . $data['wallet_account'];
        }

        if(isset($data['wallet_active']) && $data['wallet_active'] != -1 && $data['wallet_active'] !== ''){
            $where .= " AND x.active = " . $data['wallet_active'];
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

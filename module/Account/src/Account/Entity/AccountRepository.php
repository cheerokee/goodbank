<?php

namespace Account\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

class AccountRepository extends EntityRepository
{
    public function findByFilter($data){

        $alias = 'x';
        $tabela = 'Account\Entity\Account';

        $where = "1=1";

        if(isset($data['account_user_id']) && $data['account_user_id'] != ''){
            $where .= " AND x.user = " . $data['account_user_id'];
        }

        if(isset($data['account_bank_id']) && $data['account_bank_id'] != ''){
            $where .= " AND x.bank = " . $data['account_bank_id'];
        }

        if(isset($data['account_agency']) && $data['account_agency'] != ''){
            $where .= " AND x.agency = " . $data['account_agency'];
        }

        if(isset($data['account_account-number']) && $data['account_account-number'] != ''){
            $where .= " AND x.account_number = '" . $data['account_account-number']."'";
        }

        if(isset($data['account_cnpj']) && $data['account_cnpj'] != ''){
            $where .= " AND x.cnpj = '" . $data['account_cnpj']."'";
        }

        if(isset($data['account_type']) && $data['account_type'] != ''){
            $where .= " AND x.type = '" . $data['account_type']."'";
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

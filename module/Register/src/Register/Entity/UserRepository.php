<?php

namespace Register\Entity;

use Base\Controller\BaseFunctions;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

class UserRepository extends EntityRepository
{
    public function findByFilter($data){
        /**
         * @var BaseFunctions $functions
         */
        $functions = new BaseFunctions();

        $alias = 'x';
        $tabela = 'Register\Entity\User';

        $where = "1=1";

        $views = array('user','customer','administrator');

        if(!empty($views)){
            foreach($views as $view){
                if(isset($data[$view . '_name_id']) && $data[$view . '_name_id'] != ''){
                    $where .= " AND x.id = " . $data[$view . '_name_id'];
                }

                if(isset($data[$view . '_email']) && $data[$view . '_email'] != ''){
                    $where .= " AND x.email LIKE '%" . $data[$view . '_email'] . "%'";
                }

                if(isset($data[$view . '_email']) && $data[$view . '_email'] != ''){
                    $where .= " AND x.email LIKE '%" . $data[$view . '_email'] . "%'";
                }

                if(isset($data[$view . '_document']) && $data[$view . '_document'] != ''){
                    $where .= " AND x.document LIKE '%" . $functions->soNumero($data[$view . '_document']) . "%'";
                }

                if(isset($data[$view . '_active']) && $data[$view . '_active'] != ''){
                    $where .= " AND x.active = " . $data[$view . '_active'];
                }
            }
        }

        if(isset($data['user_user_id']) && $data['user_user_id'] != ''){
            $where .= " AND x.id = " . $data['user_user_id'];
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

    public function getByRole($name){

        $alias = 'p';
        $tabela = 'Register\Entity\User';

        $alias_ij1 = 'pr';
        $tabela_ij1 = 'Register\Entity\UserRole';

        $alias_ij2 = 'r';
        $tabela_ij2 = 'Acl\Entity\Role';

        $where = "r.name LIKE '%".$name."%'";

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select(array(
            $alias
        ))
            ->from($tabela,$alias)
            ->innerJoin($tabela_ij1,$alias_ij1,JOIN::WITH, $qb->expr()->andx(
                $qb->expr()->eq('p.id', 'pr.user')
            ))
            ->innerJoin($tabela_ij2,$alias_ij2,JOIN::WITH, $qb->expr()->andx(
                $qb->expr()->eq('pr.role', 'r.id')
            ))
            ->where($where);

        if(!empty($qb->getQuery()->getResult())){
            return $qb->getQuery()->getResult();
        }else{
            return array();
        }
    }
    
    public function findByEmailAndPassword($email, $password)
    {
        $user = $this->findOneBy(array(
            'email'     =>  $email
        ));
        
        if($user)
        {
            $hashSenha = $user->encryptPassword($password);
            if($hashSenha == $user->getPassword())
                return $user;
            else
                return false;
        }
        else
            return false;
    }

    public function isAuthActive($email)
    {
        $user = $this->findOneBy(array(
            'email'     =>  $email,
            'active'    =>  1
        ));

        if($user)
        {
            return true;
        }
        else
            return false;
    }

    public function findArray()
    {
        $users = $this->findAll();
        $a = array();
        foreach($users as $user)
        {
            $a[$user->getId()]['id'] = $user->getId();
            $a[$user->getId()]['name'] = $user->getName();
            $a[$user->getId()]['email'] = $user->getEmail();
        }
        
        return $a;
    }

    public function getForMenu($id,$role){
        $alias = 'p';
        $tabela = 'Register\Entity\User';

        $alias_ij1 = 'pp';
        $tabela_ij1 = 'Register\Entity\UserRole';

        $alias_ij2 = 'pr';
        $tabela_ij2 = 'Register\Entity\Role';

        $where = "pr.name LIKE '%".$role."%'";
        $where .= " AND p.id <> ".$id;

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select(array(
            $alias
        ))
            ->from($tabela,$alias)
            ->innerJoin($tabela_ij1,$alias_ij1,JOIN::WITH, $qb->expr()->andx(
                $qb->expr()->eq('p.id', 'pp.user')
            ))
            ->innerJoin($tabela_ij2,$alias_ij2,JOIN::WITH, $qb->expr()->andx(
                $qb->expr()->eq('pp.role', 'pr.id')
            ))
            ->where($where);

        if(!empty($qb->getQuery()->getResult())){
            return $qb->getQuery()->getResult();
        }else{
            return null;
        }
    }
}

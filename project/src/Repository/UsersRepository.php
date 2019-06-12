<?php

namespace App\Repository;

use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Repository\CompaniesRepository as OtherData;

/**
 * @method Users|null find($id, $lockMode = null, $lockVersion = null)
 * @method Users|null findOneBy(array $criteria, array $orderBy = null)
 * @method Users[]    findAll()
 * @method Users[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Users::class);
    }

    // /**
    //  * @return Users[] Returns an array of Users objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Users
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function filterUsers($data)
    {
        $em = $this->getEntityManager();
        $count = 0;
        $dataForExec = array();
        $sql = "SELECT fs.id, fs.first_name AS firstName, fs.last_name AS lastName, fs.birth_day AS birthDay, fs.data_sjob AS dataSJob
        FROM fos_user AS fs WHERE fs.id IN (SELECT t2.id FROM
        (SELECT f.id, f.birth_day, f.first_name, f.last_name, c.firm_name, f.company_id FROM fos_user as f 
        INNER JOIN companies as c on f.company_id = c.id) as t2
        WHERE ";
        // Образец конкотенируемой части:
        // "(first_name BETWEEN 'А%' AND 'З%') AND (company_id IN (5)) AND (birth_day BETWEEN '1990-01-01' AND '2000-01-01'))";
        if($data['literaOt'] != ''  && $data['literaDo'] != ''){
            $sql .= "( last_name BETWEEN :literaOt AND :literaDo ) ";
            $count++;
            $dataForExec[':literaOt'] = $data['literaOt'] . "%";
            $dataForExec[':literaDo'] = $data['literaDo'] . "%";
        }else if($data['literaOt'] == '' && $data['literaDo'] != ''){
            $sql .= "( last_name BETWEEN :literaOt AND :literaDo ) ";
            $count++;
            $dataForExec[':literaDo'] = $data['literaDo'] . "%";
            $dataForExec[':literaOt'] =  $this->getLitera($data['literaDo'], false) . "%";
        }else if($data['literaOt'] != '' && $data['literaDo'] == ''){
            $sql .= "( last_name BETWEEN :literaOt AND :literaDo ) ";
            $count++;
            $dataForExec[':literaDo'] = $this->getLitera($data['literaOt']) . "%";
            $dataForExec[':literaOt'] = $data['literaOt'] . "%";
        }

        if(isset($data['company']) && count($data['company']) > 0){
            if(count($data['company']) == 1){
                $company = reset($data['company']);
                if($count == 0){
                    $sql .= "( company_id IN (" . $company . ") ) ";
                }else if($count > 0){
                    $sql .= "AND ( company_id IN (" . $company . ") ) ";
                }
                $count++;
            }else if( isset($data['company']) && count($data['company']) > 1){
                $company = implode(", " , $data['company']);
                if($count == 0){
                    $sql .= "( company_id IN ( " . $company . ")) ";
                }else if($count > 0){
                    $sql .= "AND ( company_id IN (" . $company . ")) ";
                }
                $company = implode(", " , $data['company']);
            }
        }

        if($data['dateOt'] != ''  && $data['dateDo'] != ''){
            if($count == 0){
                $sql .= "( birth_day BETWEEN :dateOt AND :dateDo )) ";
            }else if($count > 0){
                $sql .= "AND ( birth_day BETWEEN :dateOt AND :dateDo )) ";
            }
            $count++;
            $dataForExec[':dateOt'] = $data['dateOt'];
            $dataForExec[':dateDo'] = $data['dateDo'];
        }else if($data['dateOt'] == '' && $data['dateDo'] != ''){
            if($count == 0){
                $sql .= "( birth_day BETWEEN (SELECT MIN(`birth_day`) AS `min_birth_day`  FROM `fos_user` ORDER BY `min_birth_day` LIMIT 1) AND :dateDo )) ";
            }else if($count > 0){
                $sql .= "AND ( birth_day BETWEEN (SELECT MIN(`birth_day`) AS `min_birth_day`  FROM `fos_user` ORDER BY `min_birth_day` LIMIT 1) AND :dateDo )) ";
            }
            $count++;
            $dataForExec[':dateDo'] = $data['dateDo'];
        }else if($data['dateOt'] != '' && $data['dateDo'] == ''){
            if($count == 0){
                $sql .= "(birth_day BETWEEN :dateOt AND NOW() ))";
            }else if($count > 0){
                $sql .= "AND (birth_day BETWEEN :dateOt AND NOW() )) ";
            }
            $count++;
            $dataForExec[':dateOt'] = $data['dateOt'];
        }else if($count > 0){
            $sql .=  ")";
        }
        $date =  $em->getConnection()->prepare($sql);
        //Выполняем.
        $date->execute($dataForExec);
        return $date->fetchAll();
    }

    public function getLitera($litera, $bool = true){
        /*
         * Передается известная буква (например первая) а затем передается bool значение если нам нужна последняя буква
         * то передается true (но это не обязательно) так как по умолчанию true а если нам нужна первая буква то передается
         * последняя буква и bool раное false*/
        $check1 = preg_match("/[0-9a-zA-Z]+/", $litera);
        $check2 = preg_match("/[0-9а-яА-ЯёЁ]+/", $litera);
        if($check2){
            if($bool){
                return "Я";
            }else{
                return "А";
            }
        }else if($check1){
            if($bool){
                return "Z";
            }else{
                return "A";
            }

        }

    }
}

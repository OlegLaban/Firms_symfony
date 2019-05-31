<?php

namespace App\Repository;

use App\Entity\Companies;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
/**
 * @method Companies|null find($id, $lockMode = null, $lockVersion = null)
 * @method Companies|null findOneBy(array $criteria, array $orderBy = null)
 * @method Companies[]    findAll()
 * @method Companies[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompaniesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Companies::class);
    }

    // /**
    //  * @return Companies[] Returns an array of Companies objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Companies
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getCompaniesWithFilter($data)
    {

        $em = $this->getEntityManager();
        dump($data);
        if(!empty($data)){
            //Получаем менеджер для работы с базой.
            $em = $this->getEntityManager();
            //Постоянная часть запроса для фильтрации. Остальная часть добавляется далее по коду.
            $sql = "SELECT t2.id, t2.firm_name AS firmName, t2.ogrn, t2.oktmo, t2.description, t2.logo, t2.address, t2.phone
                FROM companies as t2 WHERE t2.firm_name IN (SELECT t.firm_name FROM (SELECT c.firm_name, COUNT(u.company_id) as colWoker
                FROM companies as c INNER JOIN fos_user  as u ON (c.id = u.company_id) GROUP BY c.firm_name)
                as t WHERE ";
            //Переменная которая позволяет отслеживать на каком этапе построения запроса мы находимся.
            //Например: Если в форму были введены все данных то первый раз переменная увеличится на единицу в первом же блоке if[1]
            //То есть она нам нужна для того чтобы знать добавлять "AND" в начале второй части фильтрации или нет.
            //А также благодаря ей мы узнаем нужно ли закрывать скобку после первого запроса.[2]
            $count = 0;
            //Массив с параметрами. В него мы будем добавлять данные в зависимоти от выбранных параметров фильтрации.
            $paramentrs = [];

            //Первая чатсть фильтрации.
            if($data['filterFirm']['firstLit'] != '' && $data['filterFirm']['lastLit'] != '' && $count == 0){
                //[1] - вот здесь произойдет первая конкотенация в случае полностью введенной формы.
                $sql .= "(t.firm_name BETWEEN :firstLit  AND :lastLit)";
                $count++;
                //Тут все данные даны пользователем - поэтому мы просто добавляем их в параметры запроса.
                $paramentrs[':firstLit'] = $data['filterFirm']['firstLit'] . "%";
                $paramentrs[':lastLit'] =  $data['filterFirm']['lastLit']  . "%";
            }else if($data['filterFirm']['firstLit'] == '' && $data['filterFirm']['lastLit'] != '' && $count == 0){
                $sql .= "(t.firm_name BETWEEN :firstLit" . " AND " . " :lastLit )";
                $count++;
                //Тут первая буква не была дана - поэтому мы находим ее используя функцию getLitera.
                $paramentrs[':firstLit'] = $this->getLitera($data['filterFirm']['lastLit'], false)  . "%";
                $paramentrs[':lastLit'] = $data['filterFirm']['lastLit']  . "%";
            }else if($data['filterFirm']['firstLit'] != '' && $data['filterFirm']['lastLit'] == '' && $count == 0){
                $sql .= "(t.firm_name BETWEEN :firstLit AND :lastLit )";
                //Тут вторая буква не была дана - поэтому мы находим ее используя функцию getLitera.
                $paramentrs[':lastLit'] =  $this->getLitera($data['filterFirm']['firstLit']) . "%";
                $paramentrs[':firstLit'] = $data['filterFirm']['firstLit'] . "%";
                $count++;
            }

            //Вторая часть фильтрации.
            if($data['filterFirm']['chisloOt'] != '0' && $data['filterFirm']['chisloDo'] != '0' && $count == 0){
                $sql .=  "(colWoker BETWEEN :chisloOt AND :chisloDo ))";
                $count++;
                $paramentrs[':chisloDo'] = $data['filterFirm']['chisloDo'];
                $paramentrs[':chisloOt'] = $data['filterFirm']['chisloOt'];
            }else if($data['filterFirm']['chisloOt'] != '0' && $data['filterFirm']['chisloDo'] != '0' && $count == 1){
                $sql .=  " AND (colWoker BETWEEN :chisloOt AND :chisloDo ))";

                $paramentrs[':chisloDo'] = $data['filterFirm']['chisloDo'];
                $paramentrs[':chisloOt'] = $data['filterFirm']['chisloOt'];
                $count++;
            }else if($data['filterFirm']['chisloOt'] == '0' && $data['filterFirm']['chisloDo'] == '0' && $count == 1){
                //[2] - закрываем скобку запроса в случае если фильтрация по кл-ву сотрудников не идет.
                $sql .=  " )";
            }else if($data['filterFirm']['chisloOt'] != '0' && $data['filterFirm']['chisloDo'] == '0'){
                if($count == 1) {
                    $sql .= "AND";
                }
                $sql .= "(colWoker BETWEEN :chisloOt AND :chisloDo ))";
                $paramentrs[':chisloDo'] = $data['filterFirm']['chisloDo'];
                $paramentrs[':chisloOt'] = $data['filterFirm']['chisloOt'];
            }else if($data['filterFirm']['chisloOt'] == '0' && $data['filterFirm']['chisloDo'] != '0'){
                if($count == 1) {
                    $sql .= " AND ";
                }
                $sql .= "(colWoker BETWEEN :chisloOt AND :chisloDo ))";
                $paramentrs[':chisloOt'] = $data['filterFirm']['chisloOt'];
                $paramentrs[':chisloDo'] = $data['filterFirm']['chisloDo'];
            }
            //Подготавливаем запрос.
            $date =  $em->getConnection()->prepare($sql);
            //Выполняем.
            $date->execute($paramentrs);
            return $date->fetchAll();

        }
    }

    /**
     * $litera Сюда передается буква как латинская так кирилица"
     * $bool Сюда передается булева значение первая/последняя (false/true) по умолчанию идет как последняя.
     */
    public function getLitera($litera, $bool = true){
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

    public function dFC($data){
        /*
         * dFC - dataFilterCorrect - проверяет не был ли отправлена пустая форма.
         */
        if($data['filterFirm']['firstLit'] == '' && $data['filterFirm']['lastLit'] == '' && $data['filterFirm']['chisloOt'] == '0' && $data['filterFirm']['chisloDo'] == '0'){
            return false;
        }
        return true;
    }
}

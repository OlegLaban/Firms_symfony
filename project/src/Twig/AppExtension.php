<?php


namespace App\Twig;



use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{

    public function getFilters()
    {
       return [
         new TwigFilter('corAge', [$this, 'correctAge']),
       ];
    }

    public function correctAge($data)
    {
        if(is_string($data)){
            $data =  strtotime("$data GMT");
            $result = floor((time() - $data)/31556926);
            return $result;
        }else if(is_int($data)){;
            $result = floor((time() - $data)/31556926);
            return $result;
        }else if(is_object($data)){
            $result = floor((time() - intval($data->getTimestamp()))/31556926);
            return $result;
        }


    }

}
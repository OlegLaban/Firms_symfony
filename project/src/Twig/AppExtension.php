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

    public function correctAge(string $data)
    {
        $date =  strtotime("$data GMT");
        $result = floor((time() - $date)/31556926);
        return $result;

    }

}
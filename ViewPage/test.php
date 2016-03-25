<?php


include __DIR__ . '/../Trunk-Dev/DBFilm/DBFilm.php';
include __DIR__ . '/../Trunk/Core/Bootstrap.php';
include __DIR__ . '/../Trunk-Dev/ThunderLXOptimizer/ThunderLXOptimizer.php';
use Trunk\DBFilm\DBFilm;

try {
    //$t = new DBFilm();
    //$t->fetchNewFilms(6.5);
    //$t->fetchFilm();
    $t = new \Trunk\Aria2\Aria2();
    $t->poll();
}catch(\Exception $ex){
    echo $ex->getMessage();
}

//$xlo = new \Trunk\ThunderLXOptimizer\ThunderLXOptimizer();
//$xlo->poll();
//$xlo->optimizeUrl("ed2k://|file|[%E7%94%B5%E5%BD%B1%E4%B8%8B%E8%BD%BDwww.qiqipu.com]%E5%AF%BB%E9%BE%99%E8%AF%80.HD1280%E8%B6%85%E6%B8%85%E5%9B%BD%E8%AF%AD%E4%B8%AD%E8%8B%B1%E5%8F%8C%E5%AD%97.mp4|2851177195|53469A1B818662D1586893C27835AE78|h=WH2ULEGLUZGILBSKHD7ZM4YGVGRTK2HD|/","[电影下载www.qiqipu.com]寻龙诀.HD1280超清国语中英双字.mp4","","");

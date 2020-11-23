 
    <?php 
    function secondsToTime($seconds) {
    if($seconds>86400){
        $dtF = new \DateTime('@0');
        $dtT = new \DateTime("@$seconds");
        return $dtF->diff($dtT)->format('%adays %hhrs %imints');
    }else{
        $dtF = new \DateTime('@0');
        $dtT = new \DateTime("@$seconds");
        return $dtF->diff($dtT)->format('%hhrs %imints');
    }
}

//echo secondsToTime(5000);

$init = 685;
$hours = floor($init / 3600);
$minutes = floor(($init / 60) % 60);
$seconds = $init % 60;

echo "$hours:$minutes:$seconds";
?>
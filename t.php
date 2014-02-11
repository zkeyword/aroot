<?php
/*include 'aroot/debug/chromephp-master/ChromePhp.php';
ChromePhp::log('Hello console!');
ChromePhp::log($_SERVER);
ChromePhp::warn('something went wrong!');
debug_backtrace();*/
?>

<?php

$items = array(
    array('id' => 1, 'pid' => 0, 'name' => '一级11' ),
    array('id' => 11, 'pid' => 0, 'name' => '一级12' ),
    array('id' => 2, 'pid' => 1, 'name' => '二级21' ),
    array('id' => 10, 'pid' => 11, 'name' => '二级22' ),
    array('id' => 3, 'pid' => 1, 'name' => '二级23' ),
    array('id' => 12, 'pid' => 11, 'name' => '二级24' ),
    array('id' => 9, 'pid' => 1, 'name' => '二级25' )
);
 
function formatTree($array, $pid = 0){
  $arr = array();
  $tem = array();
  foreach ($array as $v) {
    if ($v['pid'] == $pid) {
      $tem = formatTree($array, $v['id']);
      $tem && $v['son'] = $tem;
      $arr[] = $v;
    }
  }
  return $arr;
}

$items = formatTree($items);
//print_r($items);


function formatArr($array){
  global $arr;
  foreach ($array as $v) {
    $arr[]=array(
      'id'   => $v['id'],
      'pid'  => $v['pid'],
      'name' => $v['name'],
    );
    if (isset($v['son'])) {   
      formatArr($v['son'], $v['id']);
    }    
  }
  return $arr;
}
$items = formatArr($items);
print_r($items);
?>
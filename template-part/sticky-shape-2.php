<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Lapindos
 * @since Lapindos 1.0.0
 */


$repeat_pattern = lapindos_get_config('repeat_pattern', 1);
$control_point = lapindos_get_config('control_point', 100);

$background_color = lapindos_get_config('mobile-background-color', array('color'=>'#ffffff','alpha'=>'','rgba'=>''));

$bgcolor = wp_parse_args($background_color,array('color'=>'','alpha'=>'','rgba'=>''));
$pattern_color = isset($bgcolor['rgba']) && $bgcolor['rgba']!='' && $bgcolor['color']!='' ? $bgcolor['rgba'] : '#ffffff';

if($control_point=='') $control_point = 100;
if($repeat_pattern=='') $repeat_pattern = 1;

$height_wave = 100;

$num_wave= min(1000,max($repeat_pattern , 1));
$height_wave=min(100,max(absint($height_wave) , 0));

$wave_width= 100 / $num_wave;
$half_wave=$wave_width /2;
$hop =  $num_wave;
$path="";

$control_point=min(100,max($control_point , -100));

if($control_point < 0){
  $control_point=100 + abs($control_point);
}

for($i=0; $i < $hop ; $i++){

  $xmove=$wave_width*$i;
  $stroke=$xmove + $half_wave;
  $ymove= $i%2==1 ? 0 : $height_wave  ;
  $path.=" C".$xmove." 0,".$stroke." ".$control_point.",".($xmove+$wave_width)." 0";

}
?>
<div class="top-heading-shape">
<svg preserveAspectRatio="none" viewBox="0 0 100 100" height="100%" width="100%" version="1.1" xmlns="http://www.w3.org/2000/svg" >
   <path d="M0 -1 L0 0 <?php print $path;?> L100 0 L100 -1 Z" fill="<?php print $pattern_color;?>" stroke-width="1" stroke="rgba(0,0,0,0.1)"/> 
   <path d="M0 0 <?php print $path;?> L100 0 L100 0 L0 100 Z" fill="transparent" stroke-width="0" stroke="transparent"/> 
</svg>
</div>
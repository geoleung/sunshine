<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Lapindos
 * @since Lapindos 1.0.0
 */

$peak_position = lapindos_get_config('peak_position', 50);
$repeat_pattern = lapindos_get_config('repeat_pattern', 1);
$background_color = lapindos_get_config('mobile-background-color', array('color'=>'#ffffff','alpha'=>'','rgba'=>''));

$bgcolor = wp_parse_args($background_color,array('color'=>'','alpha'=>'','rgba'=>''));

$pattern_color = isset($bgcolor['rgba']) && $bgcolor['rgba']!='' && $bgcolor['color']!='' ? $bgcolor['rgba'] : '#ffffff';

if($peak_position=='') $peak_position = 50;
if($repeat_pattern=='') $repeat_pattern = 1;

$num_wave= min(1000,max($repeat_pattern , 1));
$wave_width= 100 / $num_wave;
$half_wave=$wave_width /2;

$hop= ($num_wave * 2) - 1;

$path="";

for($i=1; $i < $hop + 1 ; $i++){

  $xmove=$half_wave*$i;
  $ymove= $i%2==1 ? 100 : 0 ;

  if($ymove == 100){
    $xmove = ($xmove - $half_wave) + ($wave_width * absint($peak_position) / 100 );
  }

  $path.=" L".$xmove." ".$ymove;

}
?>
<div class="top-heading-shape">
	    <svg preserveAspectRatio="none" viewBox="0 0 100 100" height="100%" width="100%" version="1.1" xmlns="http://www.w3.org/2000/svg" >
	        <path d="M0 -1 L0 0 <?php print $path;?> L100 -1 Z" fill="<?php print esc_attr($pattern_color);?>" stroke-width="1" stroke="rgba(0,0,0,0.1)"/> 
	        <path d="M0 100 <?php print $path;?> L100 0 L100 100 L0 100 Z" fill="transparent" stroke-width="0" stroke="transparent"/> 
	    </svg>
</div>
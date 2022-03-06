<?php 

 function getTimeAgo($time)
 {
     $time_difference = time() - $time;

     if ($time_difference < 1) {
         return '1 second ago';
     }
     $condition = [12 * 30 * 24 * 60 * 60 => 'year', 30 * 24 * 60 * 60 => 'month', 24 * 60 * 60 => 'day', 60 * 60 => 'hour', 60 => 'minute', 1 => 'second'];

     foreach ($condition as $secs => $str) {
         $d = $time_difference / $secs;

         if ($d >= 1) {
             $t = round($d);
             return $t . ' ' . $str . ($t > 1 ? 's' : '') . ' ago';
         }
     }
 }
 
 function splitName($name)
 {
     $name = trim($name);
     $last_name = strpos($name, ' ') === false ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
     $first_name = trim(preg_replace('#' . preg_quote($last_name, '#') . '#', '', $name));
     return [$first_name, $last_name];
 }
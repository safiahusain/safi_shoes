<?php

 namespace App\Gates;
 
 class adminGate{
     
     public function check_admin($user)
     {
         if($user->email === 'karachi@gmail.com')
         {
             return true;
         }
         else
         {
             return false;
         }
     }
 }
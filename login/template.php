<?php

function the_login_header(){

  echo '<div id="back_wip"></div>';
  echo '<div id="login_form_box">';
  echo '<img src=" ' . TEMA_L_IMG . '/logo.svg' . ' " alt="" class="login_logo">';
  
  
}
add_action('login_header', 'the_login_header');

function the_login_footer(){
  echo '</div>';
}
add_action('login_footer', 'the_login_footer'); 


<?php
require '/var/www/html/wp-load.php';
$q=get_posts(['post_type'=>'wpcf7','numberposts'=>10]);
foreach($q as $p){
  echo "ID: ".$p->ID." TITLE: ".$p->post_title." SLUG: ".$p->post_name."\n";
  echo $p->post_content."\n---\n";
}

 <link rel="stylesheet" type="text/css" href="css/shadowbox.css">
 <link href="css/lity.css" rel="stylesheet"/>
 <header>        
    <div class="cntHd">

       <a href="<?php echo $domain ?>" class="logo">UNIVIDA</a>

       <nav>
           <a href="#nav2" class="open">Menu</a>

           <ul id="nav2" class="menu">
            <?php 
            foreach ($titles as $key => $value) {
              $urlio = ($key==1) ? '' : $urls[$key] ;
                echo '<li><a href="'.$domain.'/'.$urlio.'"'; 
                if ($u_id==$key && $_GET['p'] == '') {
                    echo 'class="act"';
                }

                echo ' >'.$value.'</a></li>';
            }

            ?>
        </ul>
    </nav>
</div>
</header>
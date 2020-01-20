 <header>
    <div class="cntHd">

       <a href="https://www.univida.bo" class="logo">UNIVIDA</a>

       <nav>
           <a href="#nav2" class="open">Menu</a>

           <ul id="nav2" class="menu">
            <?php
            foreach ($titles as $key => $value) {
              $urlio = ($key==1) ? '' : $urls[$key] ;
                echo '<li><a href="'.$domain.'/'.$urlio.'"';
                if ($u_id==$key) {
                    echo 'class="act"';
                }
                echo ' >'.$value.'</a></li>';
            }

            ?>
        </ul>
    </nav>
</div>
</header>

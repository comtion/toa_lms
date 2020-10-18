        <aside class="left-sidebar" id="navbar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <?php 
                                if(count($main_menu)>0){ 
                                    foreach ($main_menu as $key_menu => $value_menu) {
                                        if(isset($submenu[$value_menu['mu_id']])&&count($submenu[$value_menu['mu_id']])>0){ 
                                            $target = array();
                                            foreach ($submenu[$value_menu['mu_id']] as $key_submenu => $value_submenu) { 
                                                array_push($target, $value_submenu['mu_path']);
                                            }
                                            if(array_intersect($target, $arr_permission)){ 

                                            ?>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="<?php echo $value_menu['mu_icon']; ?>"></i><span class="hide-menu"><?php if($lang=="thai"){ echo $value_menu['mu_name_th']; }else if($lang=="english"){ echo $value_menu['mu_name_en']; }else{ echo $value_menu['mu_name_jp']; } ?></span></a>
                            <ul aria-expanded="false" class="collapse">
                                <?php foreach ($submenu[$value_menu['mu_id']] as $key_submenu => $value_submenu) { 
                                         if(isset($submenu_b[$value_submenu['mu_id']])&&count($submenu_b[$value_submenu['mu_id']])>0){
                                            $target = array();
                                            foreach ($submenu_b[$value_submenu['mu_id']] as $key_submenu_b => $value_submenu_b) { 
                                                array_push($target, $value_submenu_b['mu_path']);
                                            }
                                            if(array_intersect($target, $arr_permission)){ 
                                            ?>
                                            <li> <a class="has-arrow" href="#" aria-expanded="false"><i class="<?php echo $value_submenu['mu_icon']; ?>"></i> <?php if($lang=="thai"){ echo $value_submenu['mu_name_th']; }else if($lang=="english"){ echo $value_submenu['mu_name_en']; }else{ echo $value_submenu['mu_name_jp']; } ?></a>
                                                <ul aria-expanded="false" class="collapse">
                                                    <?php foreach ($submenu_b[$value_submenu['mu_id']] as $key_submenu_b => $value_submenu_b) {  ?>
                                                            <?php if(in_array($value_submenu_b['mu_path'], $arr_permission)){ ?>
                                                    <li class="<?php echo $page == $value_submenu_b['mu_path'] ? 'active' : '' ?>"><a href="<?php echo REAL_PATH."/".$value_submenu_b['mu_path'];?>"><i class="<?php echo $value_submenu_b['mu_icon']; ?>"></i> <?php if($lang=="thai"){ echo $value_submenu_b['mu_name_th']; }else if($lang=="english"){ echo $value_submenu_b['mu_name_en']; }else{ echo $value_submenu_b['mu_name_jp']; } ?></a></li>
                                                            <?php } ?>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                   <?php    }else{
                                                $num_chk_b = 0;
                                                foreach ($submenu_b[$value_submenu['mu_id']] as $key_submenu_b => $value_submenu_b) {
                                                    if(in_array($value_submenu_b['mu_path'], $arr_permission)){
                                                        $num_chk_b++;
                                                    }
                                                }
                                                if($num_chk_b>0){ ?>
                                            <li> <a class="has-arrow" href="#" aria-expanded="false"><i class="<?php echo $value_submenu['mu_icon']; ?>"></i> <?php if($lang=="thai"){ echo $value_submenu['mu_name_th']; }else if($lang=="english"){ echo $value_submenu['mu_name_en']; }else{ echo $value_submenu['mu_name_jp']; } ?></a>
                                                <ul aria-expanded="false" class="collapse">
                                                    <?php foreach ($submenu_b[$value_submenu['mu_id']] as $key_submenu_b => $value_submenu_b) {  ?>
                                                            <?php if(in_array($value_submenu_b['mu_path'], $arr_permission)){ ?>
                                                    <li class="<?php echo $page == $value_submenu_b['mu_path'] ? 'active' : '' ?>"><a href="<?php echo REAL_PATH."/".$value_submenu_b['mu_path'];?>"><i class="<?php echo $value_submenu_b['mu_icon']; ?>"></i> <?php if($lang=="thai"){ echo $value_submenu_b['mu_name_th']; }else if($lang=="english"){ echo $value_submenu_b['mu_name_en']; }else{ echo $value_submenu_b['mu_name_jp']; } ?></a></li>
                                                            <?php } ?>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                   <?php 
                                                }
                                            }
                                        }else{
                                            if(in_array($value_submenu['mu_path'], $arr_permission)){
                                    ?>
                                    <li class="<?php echo $page == $value_submenu['mu_path'] ? 'active' : '' ?>"><a href="<?php echo REAL_PATH."/".$value_submenu['mu_path'];?>"><i class="<?php echo $value_submenu['mu_icon']; ?>"></i> <?php if($lang=="thai"){ echo $value_submenu['mu_name_th']; }else if($lang=="english"){ echo $value_submenu['mu_name_en']; }else{ echo $value_submenu['mu_name_jp']; } ?></a></li>
                                <?php       }
                                        }
                                    } ?>
                            </ul>
                        </li>
                        <?php           }
                                        else{
                                            $num_a = 0;$target_cc = array();
                                            foreach ($submenu[$value_menu['mu_id']] as $key_submenu => $value_submenu) { 
                                                if(isset($submenu_b[$value_submenu['mu_id']])&&count($submenu_b[$value_submenu['mu_id']])>0){
                                                    foreach ($submenu_b[$value_submenu['mu_id']] as $key_submenu_b => $value_submenu_b) { 
                                                        if(in_array($value_submenu_b['mu_path'], $arr_permission)){
                                                            $num_a++;
                                                            array_push($target_cc, $value_menu['mu_path']);
                                                        }
                                                    }
                                                }
                                            }
                                            if($num_a>0){
                                                if(in_array($value_menu['mu_path'], $target_cc)){

?>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="<?php echo $value_menu['mu_icon']; ?>"></i><span class="hide-menu"><?php if($lang=="thai"){ echo $value_menu['mu_name_th']; }else if($lang=="english"){ echo $value_menu['mu_name_en']; }else{ echo $value_menu['mu_name_jp']; } ?></span></a>
                            <ul aria-expanded="false" class="collapse">
                                <?php foreach ($submenu[$value_menu['mu_id']] as $key_submenu => $value_submenu) { 
                                         if(isset($submenu_b[$value_submenu['mu_id']])&&count($submenu_b[$value_submenu['mu_id']])>0){
                                            $target = array();
                                            foreach ($submenu_b[$value_submenu['mu_id']] as $key_submenu_b => $value_submenu_b) { 
                                                array_push($target, $value_submenu_b['mu_path']);
                                            }
                                            if(array_intersect($target, $arr_permission)){ 
                                            ?>
                                            <li> <a class="has-arrow" href="#" aria-expanded="false"><i class="<?php echo $value_submenu['mu_icon']; ?>"></i> <?php if($lang=="thai"){ echo $value_submenu['mu_name_th']; }else if($lang=="english"){ echo $value_submenu['mu_name_en']; }else{ echo $value_submenu['mu_name_jp']; } ?></a>
                                                <ul aria-expanded="false" class="collapse">
                                                    <?php foreach ($submenu_b[$value_submenu['mu_id']] as $key_submenu_b => $value_submenu_b) {  ?>
                                                            <?php if(in_array($value_submenu_b['mu_path'], $arr_permission)){ ?>
                                                    <li class="<?php echo $page == $value_submenu_b['mu_path'] ? 'active' : '' ?>"><a href="<?php echo REAL_PATH."/".$value_submenu_b['mu_path'];?>"><i class="<?php echo $value_submenu_b['mu_icon']; ?>"></i> <?php if($lang=="thai"){ echo $value_submenu_b['mu_name_th']; }else if($lang=="english"){ echo $value_submenu_b['mu_name_en']; }else{ echo $value_submenu_b['mu_name_jp']; }  ?></a></li>
                                                            <?php } ?>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                   <?php    }else{
                                                $num_chk_b = 0;
                                                foreach ($submenu_b[$value_submenu['mu_id']] as $key_submenu_b => $value_submenu_b) {
                                                    if(in_array($value_submenu_b['mu_path'], $arr_permission)){
                                                        $num_chk_b++;
                                                    }
                                                }
                                                if($num_chk_b>0){ ?>
                                            <li> <a class="has-arrow" href="#" aria-expanded="false"><i class="<?php echo $value_submenu['mu_icon']; ?>"></i> <?php if($lang=="thai"){ echo $value_submenu['mu_name_th']; }else if($lang=="english"){ echo $value_submenu['mu_name_en']; }else{ echo $value_submenu['mu_name_jp']; } ?></a>
                                                <ul aria-expanded="false" class="collapse">
                                                    <?php foreach ($submenu_b[$value_submenu['mu_id']] as $key_submenu_b => $value_submenu_b) {  ?>
                                                            <?php if(in_array($value_submenu_b['mu_path'], $arr_permission)){ ?>
                                                    <li class="<?php echo $page == $value_submenu_b['mu_path'] ? 'active' : '' ?>"><a href="<?php echo REAL_PATH."/".$value_submenu_b['mu_path'];?>"><i class="<?php echo $value_submenu_b['mu_icon']; ?>"></i> <?php if($lang=="thai"){ echo $value_submenu_b['mu_name_th']; }else if($lang=="english"){ echo $value_submenu_b['mu_name_en']; }else{ echo $value_submenu_b['mu_name_jp']; } ?></a></li>
                                                            <?php } ?>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                   <?php 
                                                }
                                            }
                                        }else{
                                            if(in_array($value_submenu['mu_path'], $arr_permission)){
                                    ?>
                                    <li class="<?php echo $page == $value_submenu['mu_path'] ? 'active' : '' ?>"><a href="<?php echo REAL_PATH."/".$value_submenu['mu_path'];?>"><i class="<?php echo $value_submenu['mu_icon']; ?>"></i> <?php if($lang=="thai"){ echo $value_submenu['mu_name_th']; }else if($lang=="english"){ echo $value_submenu['mu_name_en']; }else{ echo $value_submenu['mu_name_jp']; } ?></a></li>
                                <?php       }
                                        }
                                    } ?>
                            </ul>
                        </li>
                        <?php                   }
                                            }
                                        }
                                    }else{ 
                                        if(in_array($value_menu['mu_path'], $arr_permission)){
                                        ?>
                        <li class="<?php echo $page == $value_menu['mu_path'] ? 'active' : '' ?>"> <a class="waves-effect waves-dark" href="<?php echo REAL_PATH."/".$value_menu['mu_path'];?>" aria-expanded="false"><i class="<?php echo $value_menu['mu_icon']; ?>"></i> <span class="hide-menu"><?php if($lang=="thai"){ echo $value_menu['mu_name_th']; }else if($lang=="english"){ echo $value_menu['mu_name_en']; }else{ echo $value_menu['mu_name_jp']; } ?></span></a>
                                  <?php }
                                    }
                                }
                            } 
                        ?>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>

        <!-- Hide Menubar on Scroll -->
        <script>
        $( document ).ready(function() {
            var prevScrollpos = window.pageYOffset;
            window.onscroll = function() {
            var currentScrollPos = window.pageYOffset;
              if (prevScrollpos > currentScrollPos) {
                document.getElementById("navbar").style.top = "0";
              } else {
                if(currentScrollPos>4){
                document.getElementById("navbar").style.top = "-140px";
                }else{
                document.getElementById("navbar").style.top = "0";
                }
              }
              prevScrollpos = currentScrollPos;
            }
        });
        </script>
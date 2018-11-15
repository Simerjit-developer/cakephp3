<?php
if($lang=='english')
{
   require(WWW_ROOT.'files/Languages/english.php');
}
else
{
   require(WWW_ROOT.'files/Languages/portuguese.php');
}
?>
<style type="text/css">
    nav.side-navbar ul li.subactive > a {
        color: #3edad8;
        font-weight: bold;
    }
</style>
<!-- Side Navbar -->
<nav class="side-navbar">
    <!-- Sidebar Header-->
    <div class="sidebar-header d-flex align-items-center">
        <div class="avatar">
            <?php if ($authUser['image']) { ?>
                <img src="<?php echo $this->request->getAttribute('webroot') . $authUser['image']; ?>" alt="..." class="img-fluid rounded-circle">
            <?php } else { ?>
                <img src="/supperout/img/avatar-1.jpg" alt="..." class="img-fluid rounded-circle">
            <?php } ?>

        </div>
        <div class="title">
            <h1 class="h4"><?php echo $authUser['firstname'] . " " . $authUser['lastname'] ?></h1>
            <p><?php echo $authUser['role']; ?></p>
        </div>
    </div>
    <!-- Sidebar Navidation Menus--><span class="heading"><?php echo $main; ?></span>
    <ul class="list-unstyled">
        <!--<li class="active"><a href="index.html"> <i class="icon-home"></i>Home </a></li>-->
        <!--li class="active">
            <a href="tables.html"> <i class="icon-grid"></i>Tables </a>
        </li>
        <li><a href="charts.html"> <i class="fa fa-bar-chart"></i>Charts </a></li>
        <li><a href="forms.html"> <i class="icon-padnote"></i>Forms </a></li-->
       
<!--  niTin      -->

 <li class="<?php
    if ($this->request->getParam('controller') == 'Users' && $this->request->getParam('action')=="dashboard") {
        echo "active";
    }
    ?>">
    <?php
    echo $this->Html->link(
            '<i class="icon-home"></i> '.$home, ['controller' => 'Users', 'action' => 'dashboard', '_full' => true], ['escape' => false]
    );
    ?>
 </li>
  
        
<!-- //niTin     -->





 <?php if ($authUser['role'] == 'Admin') { ?>
            <li class="<?php
            if ($this->request->getParam('controller') == 'Users' && ($this->request->getParam('action') == 'index' || $this->request->getParam('action') == 'add')) {
                echo "active";
            }
            ?>">
                <a href="#userslink" aria-expanded="<?php
                if ($this->request->getParam('controller') == 'Users' && ($this->request->getParam('action') == 'index' || $this->request->getParam('action') == 'add')) {
                    echo "true";
                } else {
                    echo "false";
                }
                ?>" data-toggle="collapse"> 
                    <i class="icon-grid"></i><?php echo $users_label; ?> 
                </a>
                <ul id="userslink" class="collapse list-unstyled <?php
                        if ($this->request->getParam('controller') == 'Users' && ($this->request->getParam('action') == 'index' || $this->request->getParam('action') == 'add')) {
                            echo "show";
                        }
                        ?>">
                    <li class="<?php
                        if ($this->request->getParam('controller') == 'Users' && $this->request->getParam('action') == 'index') {
                            echo "subactive";
                        }
                        ?>"><?php
                            echo $this->Html->link(
                                    $all, ['controller' => 'Users', 'action' => 'index', '_full' => true]
                            );
                            ?> 
                    </li>
                    <li class="<?php
            if ($this->request->getParam('controller') == 'Users' && $this->request->getParam('action') == 'add') {
                echo "subactive";
            }
            ?>"><?php
        echo $this->Html->link(
                $add, ['controller' => 'Users', 'action' => 'add', '_full' => true]
        );
            ?></li>
                  </ul>
            </li>
<?php } ?>
        <li class="<?php
            if ($this->request->getParam('controller') == 'Restaurants' && $this->request->getParam('action')=="index") {
                echo "active";
            }
            ?>">
            <a href="#restaurantslink" aria-expanded="<?php
                        if ($this->request->getParam('controller') == 'Restaurants') {
                            echo "true";
                        } else {
                            echo "false";
                        }
                        ?>" data-toggle="collapse"> 
                <i class="icon-interface-windows"></i><?php echo $restaurants_label; ?> 
            </a>
            <ul id="restaurantslink" class="collapse list-unstyled <?php
                        if ($this->request->getParam('controller') == 'Restaurants') {
                            echo "show";
                        }
                        ?>">
                <li class="<?php
                        if ($this->request->getParam('controller') == 'Restaurants' && $this->request->getParam('action') == 'index') {
                            echo "subactive";
                        }
                        ?>"><?php
        echo $this->Html->link(
                $all, ['controller' => 'Restaurants', 'action' => 'index', '_full' => true]
        );
        ?>
                </li>
            <?php if ($authUser['role'] == 'Admin') { ?>
                    <li class="<?php
            if ($this->request->getParam('controller') == 'Restaurants' && $this->request->getParam('action') == 'add') {
                echo "subactive";
            }
            ?>"><?php
                    echo $this->Html->link(
                            $add, ['controller' => 'Restaurants', 'action' => 'add', '_full' => true]
                    );
                    ?></li>
                        <?php } ?>
            </ul>
        </li>
                        <?php if ($authUser['role'] == 'Admin') { ?>
            <li class="<?php
                        if ($this->request->getParam('controller') == 'Cuisines') {
                            echo "active";
                        }
                            ?>">
                <a href="#cuisineslink" aria-expanded="<?php
                            if ($this->request->getParam('controller') == 'Cuisines') {
                                echo "true";
                            } else {
                                echo "false";
                            }
                            ?>" data-toggle="collapse"> 
                    <i class="icon-interface-windows"></i><?php echo $cuisines_label; ?> 
                </a>
                <ul id="cuisineslink" class="collapse list-unstyled <?php
        if ($this->request->getParam('controller') == 'Cuisines') {
            echo "show";
        }
                            ?>">
                    <li class="<?php
            if ($this->request->getParam('controller') == 'Cuisines' && $this->request->getParam('action') == 'index') {
                echo "subactive";
            }
            ?>"><?php
                    echo $this->Html->link(
                            $all, ['controller' => 'Cuisines', 'action' => 'index', '_full' => true]
                    );
                    ?>
                    </li>
                    <li class="<?php
                            if ($this->request->getParam('controller') == 'Cuisines' && $this->request->getParam('action') == 'add') {
                                echo "subactive";
                            }
                            ?>"><?php
                    echo $this->Html->link(
                            $add, ['controller' => 'Cuisines', 'action' => 'add', '_full' => true]
                    );
                    ?></li>
                </ul>
            </li>
<?php } ?>
        <?php if ($authUser['role'] == 'Admin') { ?>
            <li class="<?php
            if ($this->request->getParam('controller') == 'Categories') {
                echo "active";
            }
            ?>">
                <a href="#categorieslink" aria-expanded="<?php
                if ($this->request->getParam('controller') == 'Categories') {
                    echo "true";
                } else {
                    echo "false";
                }
                ?>" data-toggle="collapse"> 
                    <i class="icon-interface-windows"></i><?php echo $categories_label; ?> 
                </a>
                <ul id="categorieslink" class="collapse list-unstyled <?php
                    if ($this->request->getParam('controller') == 'Categories') {
                        echo "show";
                    }
                    ?>">
                    <li class="<?php
                            if ($this->request->getParam('controller') == 'Categories' && $this->request->getParam('action') == 'index') {
                                echo "subactive";
                            }
                            ?>"><?php
                            echo $this->Html->link(
                                    $all, ['controller' => 'Categories', 'action' => 'index', '_full' => true]
                            );
                            ?>
                    </li>
                    <li class="<?php
                if ($this->request->getParam('controller') == 'Categories' && $this->request->getParam('action') == 'add') {
                    echo "subactive";
                }
                ?>"><?php
               echo $this->Html->link(
                       $add, ['controller' => 'Categories', 'action' => 'add', '_full' => true]
               );
                ?></li>
                </ul>
            </li>
            <!-- Amenities Section -->
            <li class="<?php
                        if ($this->request->getParam('controller') == 'Amenities') {
                            echo "active";
                        }
                        ?>">
            <a href="#Amenitieslink" aria-expanded="<?php
                if ($this->request->getParam('controller') == 'Amenities') {
                    echo "true";
                } else {
                    echo "false";
                }
                ?>" data-toggle="collapse"> 
                <i class="icon-interface-windows"></i><?php echo $amenities_label; ?> 
            </a>
            <ul id="Amenitieslink" class="collapse list-unstyled <?php
                        if ($this->request->getParam('controller') == 'Amenities') {
                            echo "show";
                        }
                ?>">
                <li class="<?php
            if ($this->request->getParam('controller') == 'Amenities' && $this->request->getParam('action') == 'index') {
                echo "subactive";
            }
            ?>"><?php
               echo $this->Html->link(
                       $all, ['controller' => 'Amenities', 'action' => 'index', '_full' => true]
               );
            ?>
                </li>
                <li class="<?php
            if ($this->request->getParam('controller') == 'Amenities' && $this->request->getParam('action') == 'add') {
                echo "subactive";
            }
            ?>"><?php
               echo $this->Html->link(
                       $add, ['controller' => 'Amenities', 'action' => 'add', '_full' => true]
               );
            ?>
                </li>
            </ul>
        </li>
            
                    <?php } ?>
        
        <li class="<?php
            if ($this->request->getParam('controller') == 'Waiters') {
                echo "active";
            }
            ?>">
            <a href="#waiterslink" aria-expanded="<?php
            if ($this->request->getParam('controller') == 'Waiters') {
                echo "true";
            } else {
                echo "false";
            }
            ?>" data-toggle="collapse"> 
                <i class="icon-interface-windows"></i><?php echo $waiters_label; ?> 
            </a>
            <ul id="waiterslink" class="collapse list-unstyled <?php
                        if ($this->request->getParam('controller') == 'Waiters') {
                            echo "show";
                        }
                        ?>">
                <li class="<?php
                    if ($this->request->getParam('controller') == 'Waiters' && $this->request->getParam('action') == 'index') {
                        echo "subactive";
                    }
                    ?>"><?php
                    echo $this->Html->link(
                            $all, ['controller' => 'Waiters', 'action' => 'index', '_full' => true]
                    );
                    ?>
                </li>
                <li class="<?php
            if ($this->request->getParam('controller') == 'Waiters' && $this->request->getParam('action') == 'add') {
                echo "subactive";
            }
            ?>"><?php
                echo $this->Html->link(
                        $add, ['controller' => 'Waiters', 'action' => 'add', '_full' => true]
                );
                ?></li>
            </ul>
        </li>
        <li class="<?php
                        if ($this->request->getParam('controller') == 'Tables') {
                            echo "active";
                        }
                        ?>">
            <a href="#tableslink" aria-expanded="<?php
                if ($this->request->getParam('controller') == 'Tables') {
                    echo "true";
                } else {
                    echo "false";
                }
                ?>" data-toggle="collapse"> 
                <i class="icon-interface-windows"></i><?php echo $tables_label; ?> 
            </a>
            <ul id="tableslink" class="collapse list-unstyled <?php
                        if ($this->request->getParam('controller') == 'Tables') {
                            echo "show";
                        }
                ?>">
                <li class="<?php
            if ($this->request->getParam('controller') == 'Tables' && $this->request->getParam('action') == 'index') {
                echo "subactive";
            }
            ?>"><?php
               echo $this->Html->link(
                       $all, ['controller' => 'Tables', 'action' => 'index', '_full' => true]
               );
            ?>
                </li>
            </ul>
        </li>
        <li class="<?php
                        if ($this->request->getParam('controller') == 'Menus') {
                            echo "active";
                        }
                        ?>">
            <a href="#menuslink" aria-expanded="<?php
                    if ($this->request->getParam('controller') == 'Menus') {
                        echo "true";
                    } else {
                        echo "false";
                    }
                    ?>" data-toggle="collapse"> 
                <i class="icon-interface-windows"></i><?php echo $menus_label; ?> 
            </a>
            <ul id="menuslink" class="collapse list-unstyled <?php
        if ($this->request->getParam('controller') == 'Menus') {
            echo "show";
        }
        ?>">
                <li class="<?php
            if ($this->request->getParam('controller') == 'Menus' && $this->request->getParam('action') == 'index') {
                echo "subactive";
            }
            ?>"><?php
            echo $this->Html->link(
                    $all, ['controller' => 'Menus', 'action' => 'index', '_full' => true]
            );
            ?>
                </li>
                <li class="<?php
                        if ($this->request->getParam('controller') == 'Menus' && $this->request->getParam('action') == 'add') {
                            echo "subactive";
                        }
                        ?>"><?php
                        echo $this->Html->link(
                                $add, ['controller' => 'Menus', 'action' => 'add', '_full' => true]
                        );
                        ?></li>
            </ul>
        </li>

        <li class="<?php
                if ($this->request->getParam('controller') == 'Orders') {
                    echo "active";
                }
                ?>">
            <a href="#orderslink" aria-expanded="<?php
                if ($this->request->getParam('controller') == 'Orders') {
                    echo "true";
                } else {
                    echo "false";
                }
                ?>" data-toggle="collapse"> 
                <i class="icon-interface-windows"></i><?php echo $orders_label; ?> 
            </a>
            <ul id="orderslink" class="collapse list-unstyled <?php
                if ($this->request->getParam('controller') == 'Orders') {
                    echo "show";
                }
                ?>">
                <li class="<?php
                if ($this->request->getParam('controller') == 'Orders' && $this->request->getParam('action') == 'index') {
                    echo "subactive";
                }
                ?>"><?php
                echo $this->Html->link(
                        $all, ['controller' => 'Orders', 'action' => 'index', '_full' => true]
                );
                ?>
                </li>
            </ul>
        </li>
        <?php if ($authUser['role'] == 'Admin') { ?>
        <li class="<?php
                        if ($this->request->getParam('controller') == 'Faqs') {
                            echo "active";
                        }
                        ?>">
            <a href="#faqslink" aria-expanded="<?php
                    if ($this->request->getParam('controller') == 'Faqs') {
                        echo "true";
                    } else {
                        echo "false";
                    }
                    ?>" data-toggle="collapse"> 
                <i class="icon-interface-windows"></i><?php echo $faqs_label; ?>
            </a>
            <ul id="faqslink" class="collapse list-unstyled <?php
        if ($this->request->getParam('controller') == 'Faqs') {
            echo "show";
        }
        ?>">
                <li class="<?php
            if ($this->request->getParam('controller') == 'Faqs' && $this->request->getParam('action') == 'index') {
                echo "subactive";
            }
            ?>"><?php
            echo $this->Html->link(
                    $all, ['controller' => 'Faqs', 'action' => 'index', '_full' => true]
            );
            ?>
                </li>
                <li class="<?php
                        if ($this->request->getParam('controller') == 'Faqs' && $this->request->getParam('action') == 'add') {
                            echo "subactive";
                        }
                        ?>"><?php
                        echo $this->Html->link(
                                $add, ['controller' => 'Faqs', 'action' => 'add', '_full' => true]
                        );
                        ?></li>
            </ul>
        </li>
        <?php } ?>
        <li class="<?php
                if ($this->request->getParam('controller') == 'Users' && $this->request->getParam('action') == 'edit') {
                    echo "active";
                }
                ?>">
            <a href="#profilelink" aria-expanded="<?php
                if ($this->request->getParam('controller') == 'Users') {
                    echo "true";
                } else {
                    echo "false";
                }
                ?>" data-toggle="collapse">  
                <i class="icon-interface-windows"></i><?php echo $profile; ?> 
            </a>
            <ul id="profilelink" class="collapse list-unstyled <?php
                if ($this->request->getParam('controller') == 'Users' && $this->request->getParam('action') == 'edit') {
                    echo "show";
                }
                ?>">
                <li class="<?php
                if ($this->request->getParam('controller') == 'Users' && $this->request->getParam('action') == 'edit') {
                    echo "subactive";
                }
                ?>"><?php
                echo $this->Html->link(
                        $my_profile, ['controller' => 'Users', 'action' => 'edit', $authUser['id'], '_full' => true]
                );
                ?>
                </li>
                <li class="<?php
                if ($this->request->getParam('controller') == 'Users' && $this->request->getParam('action') == 'changepassword') {
                    echo "subactive";
                }
                ?>"><?php
                echo $this->Html->link(
                        $change_password, ['controller' => 'Users', 'action' => 'changepassword', '_full' => true]
                );
                ?></li>
                <li class="<?php
                if ($this->request->getParam('controller') == 'Users' && $this->request->getParam('action') == 'settings') {
                    echo "subactive";
                }
                ?>"><?php
                echo $this->Html->link(
                        $settings, ['controller' => 'Users', 'action' => 'settings', '_full' => true]
                );
                ?></li>
            </ul>
        </li>
<!--  niTin      -->
     <?php if ($authUser['role'] == 'Admin') { ?>

 <li class="<?php
    if ($this->request->getParam('controller') == 'Commissions') {
        echo "active";
    }
    ?>">
    <?php
    echo $this->Html->link(
            '<i class="icon-interface-windows"></i>'. $commissions_label, ['controller' => 'Commissions', 'action' => 'admincommission', '_full' => true], ['escape' => false]
    );
    ?>
 </li>
<?php } ?>   
        
        
<!-- //niTin     -->
<?php if ($authUser['role'] == 'Admin') { ?>
            <li class="<?php
    if ($this->request->getParam('controller') == 'Suggestions') {
        echo "active";
    }
    ?>">
    <?php
    echo $this->Html->link(
            '<i class="icon-interface-windows"></i>'.$suggestions_label, ['controller' => 'Suggestions', 'action' => 'index', '_full' => true], ['escape' => false]
    );
    ?>
 </li>
<?php } ?>
       
        <li class="<?php
if ($this->request->getParam('controller') == 'Ratings') {
    echo "active";
}
?>">
<?php
echo $this->Html->link(
        '<i class="icon-interface-windows"></i>'.$ratings_label, ['controller' => 'Ratings', 'action' => 'index', '_full' => true], ['escape' => false]
);
?>
        </li>
        <?php if ($authUser['role'] != 'Admin') { ?>
        <li class="<?php
            if ($this->request->getParam('controller') == 'Discounts') {
                echo "active";
            }
            ?>">
                <a href="#Discountslink" aria-expanded="<?php
                if ($this->request->getParam('controller') == 'Discounts') {
                    echo "true";
                } else {
                    echo "false";
                }
                ?>" data-toggle="collapse"> 
                    <i class="icon-interface-windows"></i><?php echo $discounts_label; ?> 
                </a>
                <ul id="Discountslink" class="collapse list-unstyled <?php
                    if ($this->request->getParam('controller') == 'Discounts') {
                        echo "show";
                    }
                    ?>">
                    <li class="<?php
                            if ($this->request->getParam('controller') == 'Discounts' && $this->request->getParam('action') == 'index') {
                                echo "subactive";
                            }
                            ?>"><?php
                            echo $this->Html->link(
                                    $all, ['controller' => 'Discounts', 'action' => 'index', '_full' => true]
                            );
                            ?>
                    </li>
                    <li class="<?php
                if ($this->request->getParam('controller') == 'Discounts' && $this->request->getParam('action') == 'add') {
                    echo "subactive";
                }
                ?>"><?php
               echo $this->Html->link(
                       $add, ['controller' => 'Discounts', 'action' => 'add', '_full' => true]
               );
                ?></li>
                </ul>
            </li>
        <li class="<?php
if ($this->request->getParam('controller') == 'Enqueries') {
    echo "active";
}
?>">
<?php
echo $this->Html->link(
        '<i class="icon-interface-windows"></i>'.$enqueries_label, ['controller' => 'Enqueries', 'action' => 'add', '_full' => true], ['escape' => false]
);
?>
        </li>
        <?php } ?>
    </ul>
</nav>
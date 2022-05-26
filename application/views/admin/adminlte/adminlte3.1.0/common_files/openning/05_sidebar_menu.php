  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="index3.html" class="brand-link">
          <img src="<?php if (file_exists('assets/parallel_zero/img/company/' . $company_data['logo'])) {
                        echo base_url('assets/parallel_zero/img/company/' . $company_data['logo']);
                    } ?>" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light"><?php echo $company_data['name'] ?></span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                  <img src="<?php echo base_url('assets/parallel_zero/img/users/' . $_SESSION['user']['id'] . '/' . $_SESSION['user']['photo'] . '.jpg') ?>" class="img-circle elevation-2" alt="User Image">
              </div>
              <div class="info">
                  <a href="#" class="d-block"><?php echo $_SESSION['user']['name']; ?></a>
              </div>
          </div>

          <!-- SidebarSearch Form -->
          <!-- <div class="form-inline">
              <div class="input-group" data-widget="sidebar-search">
                  <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                  <div class="input-group-append">
                      <button class="btn btn-sidebar">
                          <i class="fas fa-search fa-fw"></i>
                      </button>
                  </div>
              </div>
          </div> -->

          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                  <?php
                    echo "\n";
                    $counter = 1;
                    $size = count($items_menu);
                    foreach ($items_menu as $item_menu) {
                        if ($counter < $size) { //This is not the last link
                            if ($item_menu['level'] == 1) {
                                if ($items_menu[$counter]['level'] == 1) {
                                    //Link parent without children
                                    echo "<li class=\"nav-item\">\n";
                                    if ($item_menu['item'] == $sections_admin['menu_active_level_1']) {
                                        echo "\t\t\t\t\t\t<a href=\"" . base_url($item_menu['link']) . "\" class=\"nav-link active\">\n";
                                    } else {
                                        echo "\t\t\t\t\t\t<a href=\"" . base_url($item_menu['link']) . "\" class=\"nav-link\">\n";
                                    }
                                    echo "\t\t\t\t\t\t<i class=\"nav-icon " . $item_menu['icon'] . "\"></i>\n";
                                    echo "\t\t\t\t\t\t\t<p>" . $item_menu['item'] . "</p>";
                                    echo "\t\t\t\t\t\t</a>\n";
                                    echo "\t\t\t\t\t</li>\n";
                                }
                                if ($items_menu[$counter]['level'] == 2) {
                                    //Link parent with children
                                    if ($item_menu['item'] == $sections_admin['menu_open']) {
                                        echo "\t\t\t\t\t<li class=\"nav-item menu-open\">\n";
                                    } else {
                                        echo "\t\t\t\t\t<li class=\"nav-item\">\n";
                                    }
                                    if ($item_menu['item'] == $sections_admin['menu_active_level_1']) {
                                        echo "\t\t\t\t\t\t<a href=\"" . base_url($item_menu['link']) . "\" class=\"nav-link active\">\n";
                                    } else {
                                        echo "\t\t\t\t\t\t<a href=\"" . base_url($item_menu['link']) . "\" class=\"nav-link\">\n";
                                    }
                                    echo "\t\t\t\t\t\t<i class=\"nav-icon " . $item_menu['icon'] . "\"></i>\n";
                                    echo "\t\t\t\t\t\t\t<p>" . $item_menu['item'] . "\n";
                                    echo "\t\t\t\t\t\t\t\t<i class=\"right fas fa-angle-left\"></i>\n";
                                    echo "\t\t\t\t\t\t\t</p>\n";
                                    echo "\t\t\t\t\t\t</a>\n";
                                }
                            } elseif ($item_menu['level'] == 2) {
                                //Link child
                                if ($items_menu[$counter - 2]['level'] == 1) {
                                    //Link first child
                                    echo "\t\t\t\t\t\t<ul class=\"nav nav-treeview\">\n";
                                }
                                echo "\t\t\t\t\t\t\t<li class=\"nav-item\">\n";
                                if ($item_menu['item'] == $sections_admin['menu_active_level_2']) {
                                    echo "\t\t\t\t\t\t\t\t<a href=\"" . base_url($item_menu['link']) . "\" class=\"nav-link active\">\n";
                                } else {
                                    echo "\t\t\t\t\t\t\t\t<a href=\"" . base_url($item_menu['link']) . "\" class=\"nav-link\">\n";
                                }
                                echo "\t\t\t\t\t\t\t\t<i class=\"nav-icon " . $item_menu['icon'] . "\"></i>\n";
                                echo "\t\t\t\t\t\t\t\t\t<p>" . $item_menu['item'] . "</p>\n";
                                echo "\t\t\t\t\t\t\t\t</a>\n";
                                echo "\t\t\t\t\t\t\t</li>\n";
                                if ($items_menu[$counter]['level'] == 1) {
                                    //Link last child
                                    echo "\t\t\t\t\t\t</ul>\n";
                                    echo "\t\t\t\t\t\t\t</li>\n";
                                }
                            }
                        } elseif ($counter == $size) { //This is the last link
                            if ($item_menu['level'] == 1) {
                                //Link parent without children and last link
                                echo "\t\t\t\t\t<li class=\"nav-item\">\n";
                                if ($item_menu['item'] == $sections_admin['menu_active_level_1']) {
                                    echo "\t\t\t\t\t\t<a href=\"" . base_url($item_menu['link']) . "\" class=\"nav-link active\">\n";
                                } else {
                                    echo "\t\t\t\t\t\t<a href=\"" . base_url($item_menu['link']) . "\" class=\"nav-link\">\n";
                                }
                                echo "\t\t\t\t\t\t<i class=\"nav-icon " . $item_menu['icon'] . "\"></i>\n";
                                echo "\t\t\t\t\t\t\t<p>" . $item_menu['item'] . "</p>";
                                echo "\t\t\t\t\t\t</a>\n";
                                echo "\t\t\t\t\t</li>\n";
                            } elseif ($item_menu['level'] == 2) {
                                //Last child and last link
                                if ($items_menu[$counter - 2]['level'] == 1) {
                                    //Link first child
                                    echo "\t\t\t\t\t\t<ul class=\"nav nav-treeview\">\n";
                                }
                                echo "\t\t\t\t\t\t\t<li class=\"nav-item\">\n";
                                if ($item_menu['item'] == $sections_admin['menu_active_level_2']) {
                                    echo "\t\t\t\t\t\t\t\t<a href=\"" . base_url($item_menu['link']) . "\" class=\"nav-link active\">\n";
                                } else {
                                    echo "\t\t\t\t\t\t\t\t<a href=\"" . base_url($item_menu['link']) . "\" class=\"nav-link\">\n";
                                }
                                echo "\t\t\t\t\t\t\t\t\t<i class=\"nav-icon " . $item_menu['icon'] . "\"></i>\n";
                                echo "\t\t\t\t\t\t\t\t\t<p>" . $item_menu['item'] . "</p>\n";
                                echo "\t\t\t\t\t\t\t\t</a>\n";
                                echo "\t\t\t\t\t\t\t</li>\n";
                                echo "\t\t\t\t\t\t</ul>\n";
                                echo "\t\t\t\t\t</li>\n";
                            }
                        }
                        $counter++;
                    }
                    ?>
              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>
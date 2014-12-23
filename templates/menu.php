<nav class="navbar" role="navigation">
            <div class = "container">
                <div class = "row">
                    <div class="navbar-header">
                        <a id="site-title" class="navbar-brand" href="<?php echo site_url()?>"><?php echo bloginfo('site_title')?></a>
                        <button type="button" class="navbar-toggle" data-toggle="collapse"
                                data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <?php
                    wp_nav_menu(array(
                    	'menu'            => 'main-menu',
                    	'theme_location'  => 'main-menu',
                    	'depth'           => 2,
                    	'container'       => 'div',
                    	'container_class' => 'collapse navbar-collapse',
                    	'container_id'    => 'navbar-collapse',
                    	'menu_class'      => 'nav navbar-nav navbar-right',
                    	'fallback_cb'     => 'wp_bootstrap_navwalker::fallback',
                    	'walker'          => new wp_bootstrap_navwalker()
                    ));
                    ?>
                </div>
            </div>
		</nav>
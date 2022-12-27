        <div class="heading-block border-bottom-0">
            <h3 class="nott ls0">Portfolio</h3>
        </div>
        <div id="section-portfolio" class="page-section">
        </div>
        <div id="portfolio" class="portfolio row grid-container gutter-20">

            <?php
            foreach ($projects as $project) {
                echo "<article class=\"portfolio-item col-12 col-sm-6 col-md-4 pf-media pf-icons\">\n";
                echo "<div class=\"grid-inner\"\n>";
                echo "<div class=\"portfolio-image\">\n";
                echo "<img src=\"" . base_url('assets/parallel_zero/img/sections/portfolio/') . $project['image'] . "\" alt=\"\">\n";
                echo "<div class=\"bg-overlay\">\n";
                echo "<div class=\"bg-overlay-content dark\" data-hover-animate=\"fadeIn\" data-hover-speed=\"500\">\n";
                echo "<a href=\"#\" class=\"overlay-trigger-icon bg-light text-dark\" data-hover-animate=\"fadeIn\" data-hover-speed=\"500\"><i class=\"icon-line-ellipsis\"></i></a>\n";
                echo "</div>\n";
                echo "<div class=\"bg-overlay-bg dark\" data-hover-animate=\"fadeIn\" data-hover-speed=\"500\"></div>\n";
                echo "</div>\n";
                echo "</div>\n";
                echo "<div class=\"portfolio-desc\">\n";
                echo "<h3><a href=\"#\">" . $project['title'] . "</a></h3>";
                echo "<span>" . $project['short_description'] . "</span>\n";
                echo "</div>\n";
                echo "</div>\n";
                echo "</article>\n";
            }
            ?>

        </div>

        <div class="center">
            <a href="demo-seo-about.html" class="button button-large button-rounded text-capitalize ml-0 mt-5 ls0">View All Works</a>
        </div>
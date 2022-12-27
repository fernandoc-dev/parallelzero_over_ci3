<div class="row gutter-40 col-mb-80">
    <!-- Post Content
						============================================= -->
    <div class="postcontent col-lg-9">

        <h3><?php echo $course['course'] ?></h3>

        <ul class="list-group">
            <?php
            foreach ($lessons as $lesson) {
                echo "<li class=\"list-group-item\"><a href=\"" . $course['url'] . "/" . $lesson['url'] . "\">" . $lesson['title'] . "</a></li>\n";
            }
            ?>
        </ul>
    </div>
</div>
<h1><?php echo $course['course'] ?></h1>
<div class="container">
    <div class="row gutter-40 col-mb-80">

        <div class="postcontent col-lg-3">

            <ul class="list-group">
                <?php
                foreach ($lessons as $lesson_item) {
                    if ($lesson_item['url'] == $lesson['url']) {
                        echo "<li class=\"list-group-item\"><a href=\"" . base_url('courses/') . $course['url'] . "/" . $lesson_item['url'] . "\" class=\"font-weight-bold\"><u>" . $lesson_item['title'] . "</u></a></li>\n";
                    } else {
                        echo "<li class=\"list-group-item\"><a href=\"" . base_url('courses/') . $course['url'] . "/" . $lesson_item['url'] . "\">" . $lesson_item['title'] . "</a></li>\n";
                    }
                }
                ?>
            </ul>
        </div>
        <div class="col-lg-9">
            <h2><?php echo $lesson['title'] ?></h2>
            <p><?php echo $lesson['content'] ?></p>
        </div>
    </div>
    <!-- Pagination -->
    <div class="row">
        <div class="col-lg-12">
            <ul class="pagination justify-content-center mt-3">
                <li class="page-item"><a class="page-link" href="#" aria-label="Previous"> <span aria-hidden="true">&laquo;</span></a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">4</a></li>
                <li class="page-item"><a class="page-link" href="#">5</a></li>
                <li class="page-item"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
            </ul>
        </div>
    </div>
</div>
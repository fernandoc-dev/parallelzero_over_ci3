<?php echo "\n\n"; ?>
<!-- Modal -->
<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    <?php
                    if (isset($_SESSION['title'])) {
                        echo $_SESSION['title'];
                    }
                    ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                ?>
            </div>
            <div class="modal-footer">
                <?php
                if (isset($_SESSION['btn1'])) {
                    echo ("<button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">" . $_SESSION['btn1'] . "</button>");
                };
                if (isset($_SESSION['btn2'])) {
                    echo ("<button type=\"button\" class=\"btn btn-primary\" data-dismiss=\"modal\">" . $_SESSION['btn2'] . "</button>");
                };
                if (isset($_SESSION['link'])) {
                    echo ("<button type=\"button\" class=\"btn btn-primary\"><a style=\"color:white\" href=\"" . $_SESSION['link'] . "\">" . $_SESSION['linkm'] . "</a></button>");
                };
                ?>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_SESSION['message'])) {
    echo "<script>$('#Modal').modal('show')</script>";
}
?>
<!-- Modal -->
</body>

</html>
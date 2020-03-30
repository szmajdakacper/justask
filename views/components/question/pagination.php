<?php
if(isset($args['currentPage'])) {
    $totalNumberOfPages = $args['totalNumberOfPages'];
    $currentPage = $args['currentPage'];
    $previousPage = $currentPage - 1;
    $nextPage = $currentPage + 1;
?>
<div class="d-flex justify-content-center">
    <nav class="">
        <ul class="pagination">
            <li class="page-item"><a class="page-link" href="<?php echo getenv('website_path').'question/all'; ?>">First</a></li>
            <?php 
            if($previousPage !== 0) {
                ?><li class="page-item"><a class="page-link" href="<?php echo getenv('website_path').'question/all/'.$previousPage; ?>"><?php echo $previousPage ?></a></li><?php
            }            
            ?>
            <li class="page-item"><a class="page-link" href="<?php echo getenv('website_path').'question/all/'.$currentPage; ?>"><?php echo $currentPage ?></a></li>
            <?php
            if($nextPage <= $totalNumberOfPages) {
                ?><li class="page-item"><a class="page-link" href="<?php echo getenv('website_path').'question/all/'.$nextPage; ?>"><?php echo $nextPage ?></a></li><?php
            }
            ?>
            <?php
            if($totalNumberOfPages != 0) {
                ?><li class="page-item"><a class="page-link" href="<?php echo getenv('website_path').'question/all/'.$totalNumberOfPages; ?>">Last</a></li><?php
            }
            ?>
        </ul>
    </nav>
</div>


<?php } ?>
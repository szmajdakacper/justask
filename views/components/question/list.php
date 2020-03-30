<?php
if(isset($args['questions'])) {
    foreach($args['questions'] as $question) {
        ?>
        <a class="text-decoration-none text-dark" href="<?php echo getenv('website_path').'question/show/'.$question['id'] ?>">
            <div class="card m-2 shadow">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $question['title'] ?></h5>
                    <p class="card-text"><?php echo $question['content'] ?></p>  
                </div>
                <div class="card-footer">
                    <small class="text-muted">Autor: <?php echo $question['name'] ?></small>
                </div>
            </div>
        </a>
        <?php
    }
}
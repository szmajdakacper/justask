<?php
$question = $args['question'];
?>
<div class="card m-2 shadow">
    <div class="card-body">
        <h5 class="card-title"><?php echo $question['title'] ?></h5>
        <p class="card-text"><?php echo $question['content'] ?></p>  
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-9">
                <small class="text-muted">Autor: <?php echo $question['name'] ?>, IP:<?php echo $question['ip'] ?></small>
            </div>
            <div class="col-3">
                <small class="text-muted">Created at: <?php echo $question['created_at'] ?></small>
            </div>
        </div>
    </div>
</div>


<ul class="list-group m-2 shadow-sm">
    <?php
    foreach($args['answers'] as $answer) {
        ?>
        <li class="list-group-item answers">
            <div class="row">
                <div class="col-10">
                    <p><?php echo $answer['name'].': '.$answer['content'] ?></p>
                    <small class="text-dark">IP:<?php echo $answer['ip'] ?></small>
                </div>
                <div class="col-1">
                    <a class="text-decoration-none" href="<?php echo getenv('website_path').'question/like/'.$answer['id']; ?>">
                        <i class="fas fa-thumbs-up"></i>
                        <p><?php echo $answer['likes'] ?></p>
                    </a>
                </div>
                <div class="col-1">
                <a class="text-decoration-none text-danger" href="<?php echo getenv('website_path').'question/unlike/'.$answer['id']; ?>">
                        <i class="fas fa-thumbs-down"></i>
                        <p><?php echo $answer['unlikes'] ?></p>
                    </a>
                </div>
            </div>
        </li>
        <?php
    }
    ?>
</ul>


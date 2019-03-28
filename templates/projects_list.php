<?php
    include_once '../config.php';
    include_once '../class/DB.php';

    $db = new DB();
    session_start();
    if (isset($_SESSION['user_id'])){
        $projects = $db->queryGet('SELECT * FROM projects WHERE user_id = "' . $_SESSION['user_id'] . '"');
    } else {
        $projects = array();
    }
?>
<?php for ($i = 0; $i < count($projects); $i++):?>
    <div class="project-block">
        <div class="preloader" id="preloader<?php echo $projects[$i]['id'];?>">
            <div class="page-loader-circle"></div>
        </div>
        <div class="main-panel same-block">
            <span class="glyphicon glyphicon-th-list btn-lg"></span>
            <span class="glyphicon glyphicon-trash btn-lg right-buttons" onclick="remove_project(<?php echo $projects[$i]['id'];?>)"></span>
            <span class="glyphicon glyphicon-pencil btn-lg right-buttons" onclick="edit_project(<?php echo $projects[$i]['id'];?>)" data-toggle="modal" data-target="#modal"></span>
            <span><?php echo $projects[$i]['name'];?></span>
        </div>
        <div class="add-panel same-block">
            <div class="glyphicon glyphicon-plus btn-lg"></div>
                <form id="task_form<?php echo $projects[$i]['id'];?>" method="POST" enctype="multipart/form-data" name="task_form">
                    <div class="input-group">
                        <input type="text" class="form-control" name="add_task_name" placeholder="Task text" value="" required>
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="button" onclick="add_task(<?php echo $projects[$i]['id'];?>)">
                                Add task
                            </button>
                        </span>
                    </div>
                </form>
        </div>
        <table class="content-block" cellspacing="0" border="1px">
            <?php
                $tasks = $db->queryGet('SELECT t.task_id, t.name, t.status FROM tasks as t WHERE t.project_id=' . $projects[$i]['id'] . ' ORDER BY status, priority DESC');
                $cnt = 0;
                for ($j = 0; $j < count($tasks); $j++) {
                    if ($tasks[$j]['status'] == 1) {
                        $cnt++;
                    }
                }
            ?>
            <?php for ($j = 0; $j < count($tasks); $j++):?>
            <tr class="list-element <?php echo $tasks[$j]['status'] == 1? 'checked-element' : ''; ?>">
                <td class="checkbox-container" align="center"><input type="checkbox" disabled <?php echo $tasks[$j]['status'] == 1? 'checked' : ''; ?>/></td>
                <td class="text-container"><?php echo $tasks[$j]['name']; ?></td>
                <td class="buttons-container" align="center">
                	<?php if ($tasks[$j]['status'] == 0):?>
                    	<div class="glyphicon glyphicon-sort btn-sm" data-toggle="popover" data-placement="left" data-html="true" data-content='<?php if($j != 0): ?><div class="glyphicon glyphicon-arrow-up" onclick="task_up(<?php echo $tasks[$j]['task_id'];?>, <?php echo $projects[$i]['id'];?>)"></div><?php endif; ?><?php if($j != (count($tasks)-(1+$cnt))): ?><div class="glyphicon glyphicon-arrow-down"  onclick="task_down(<?php echo $tasks[$j]['task_id'];?>, <?php echo $projects[$i]['id'];?>)"></div><?php endif; ?>'></div>
                    <?php endif;?>
                    <div class="glyphicon glyphicon-pencil btn-sm" data-toggle="modal" data-target="#modal" onclick="edit_task(<?php echo $tasks[$j]['task_id'];?>, <?php echo $projects[$i]['id'];?>)"></div>
                    <div class="glyphicon glyphicon-trash btn-sm" onclick="remove_task(<?php echo $tasks[$j]['task_id'];?>, <?php echo $projects[$i]['id'];?>)"></div>
                </td>
            </tr>
            <?php endfor;?>
        </table>
    </div>
<?php endfor;?>
<?php if (isset($_SESSION['user_id'])):?>
<div class="same-block main-button-block">
    <button class="btn-lg" onclick="add_new_list()" data-toggle="modal" data-target="#modal">Add TODO list</button>
</div>
<?php endif;?>
<script>
    $(document).ready(function () {
        $('[data-toggle="popover"]').popover();
    });
</script>

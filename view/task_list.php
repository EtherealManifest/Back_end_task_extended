<?php include('view/header.php')?>
<!--When the data gets here, it needs to be sorted by category, then preseted-->
<section id='list' class="list">
    <header class="list_row list_header">
        <h1>Tasks that need doing</h1>
        <?php foreach($categories as $category):?>
            <div class= "Token_item">
            <p class = "header"><?= $category["categoryName"]?></p>
            <?php foreach ($tasks as $task) : ?>
                <?php foreach ($task as $item): ?>
                    <?php if( $item["categoryID"] == $category["categoryID"]){?>
                    <div class="Task_list_item">
                        <div class = "task_title">
                            <p><?=$item['Title']?></p>
                        </div>
                        <div class = "Category">
                            <p>Category: <?php print_r(get_category_name($item["categoryID"])[0])?></p>
                        </div>
                        <div class = "task_description">
                            <p>Description: <?=$item['Description']?></p>
                        </div>
                        <form class = 'delete_button_form' action="." method="POST">
                            <input type="hidden" name="action" value="delete-task">
                            <input type="hidden" name="task" value=<?=$item['ItemNum']?>>
                            <button class="delete_task_button">-X-</button>
                        </form>
                    </div>
                    <?php } ?>
                <?php endforeach; ?>
            <?php endforeach; ?>
            </div>
        <?php endforeach;?>
    </header>
</section>
<section>
    <h2>Insert Task / Create Task</h2>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <input type="hidden" name="action" value="insert">
        <label for="newName">Task Name: </label>
        <input type="text" id="newName" name="task_name" required>
        <label for="description">Descripton:</label>
        <input type="text" id="description" name="description" required>
        <label for="category">Category:</label>
        <select id="category" name="category">
            <option value="none" selected>No Category</option>
            <?php if($categories){
                foreach($categories as $category): ?>
                    <option value = <?=$category[0] ?>><?=$category[0].": ".$category[1]?> </option>
                <?php endforeach; ?>
            <?php }else { ?>
                <option value = "none">No Category</option>
            <?php } ?>
        </select>
        <button type="submit">Submit</button>
    </form>
</section>
<section>
    <h2>Create a new Category!</h2>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <input type="hidden" name="action" value="new_category">
        <label for="categoryName">Category Name: </label>
        <input type="text" id="categoryName" name="categoryName" required>
        <button type="submit">Submit</button>
    </form>
</section>



<section>
    <h2>Remove a Category!</h2>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <input type="hidden" name="action" value="delete_category">
        <label for="category">Category to Delete:</label>
        <select id="category" name="category">
            <option value="none" selected>No Category</option>
            <?php if($categories){ ?>
                <?php foreach($categories as $category): ?>
                        <option value = <?=$category[0] ?>><?=$category[0].": ".$category[1]?> </option>
                <?php endforeach; ?>
                <?php }else { ?>
                <option value = "none">No Category</option>
            <?php } ?>
        </select>
        <button type="submit">Submit</button>
    </form>
</section>



<?php include('view/footer.php')?>

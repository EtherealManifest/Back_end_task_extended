<?php include('header.php')?>
<h2>Error</h2>
<!--when this is called from the index file, we creaded a $error variable. When we include this code there,
we use that variable down below. Thats why there is no declaration -->
<p><?= $error ?></p>
<br>
<p><a href=".">Back to List </a></p>
<?php include('footer.php')?>


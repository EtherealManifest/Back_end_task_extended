<!--Create, Read, Update, Delete operations -->
<!--Because we arent ever "targeting" a specific task, Update will not be needed. Deleting and recreating
the Object will be enough for our purposes -->
<!-- Each of these will need to connect to the db variable, our php Data Object.-->
<?php
#get the full list of the items currently in the todo list
#TODO: Modify so that the data that is returned is sorted as a list of lists, by category
function get_todo_list(){
    $list = array();
    global $db;
    #Our query will be run on the database, so in this case it needs everything from our task list.
    #first, get the list of all the categories and store them in a list
    $query = 'SELECT * FROM `categories`';
    $statement = $db->prepare($query);
    $statement->execute();
    $categories = $statement->fetchAll();
    $statement->closeCursor();

    #Items is now a list of all of the categories. 

    foreach($categories as $category) :
        #this should get every item
        $query = 'SELECT * FROM `todoitem` WHERE categoryID = :categoryID';
        $statement = $db->prepare($query);
        $statement->bindValue(':categoryID', $category[0]);
        $statement->execute();
        $data = $statement->fetchAll();
        $statement->closeCursor();
        array_push($list, $data);
    endforeach;
    return $list;

}

function delete_item($item_num){
    global $db;
    if($item_num){
        $query = "DELETE FROM `todoitem` WHERE ItemNum = :itemNum";
    } else {
        header("Location: index.php?message=Item Does Not Exist");
    }
    $statement = $db->prepare($query);
    $statement->bindValue(':itemNum', $item_num);
    $statement->execute();
    #there is no new data to display, so nothing needs to be returned
    $statement->closeCursor();
}



#search for a category of items. category will always be selected from a list
function get_todo_list_category($categoryID = ''){
    global $db;
    #Our query will be run on the database, so in this case it needs everything from our task list.
    if($categoryID != ''){
        $query = 'SELECT * FROM `todoitem` where `categoryID`=:category';
        $statement = $db->prepare($query);
        $statement->bindValue(':category', $categoryID);
    } else{
        $query = 'SELECT * FROM `categories`';
        $statement = $db->prepare($query);
    }
    $statement->execute();
    $items = $statement->fetchAll();
    $statement->closeCursor();
    return $items;
}

#add a new item to the task list
#TODO: ADD AN INPUT FOR THE CATEGORY AS A DROPDOWN OF EXISTING CATEGORIES
function add_task($itemTitle, $itemDescription, $categoryID){
    global $db;
    #in the statements below, the :names are placeholders, they are filled in later. they could also 
    #be changed to ?, and assigned the same way, but naming them makes keeping track of the
    #assginment easier.
    if($itemTitle){
        if($itemDescription){
            $query = "INSERT INTO todoitem (Title, Description, categoryID) 
            VALUES (:itemTitle, :itemDescription, :categoryID)";
        }
        else{
            $query = "INSERT INTO todoitem (Title, Description, categoryID) 
            VALUES (:itemTitle, '', :categoryID)";
        }
    } else {
        return;
    }
    $statement = $db->prepare($query);
    $statement->bindValue(':itemTitle', $itemTitle);
    $statement->bindValue(':itemDescription', $itemDescription);
    $statement->bindValue(':categoryID', $categoryID);
    $statement->execute();
    #there is no new data to display, so nothing needs to be returned
    $statement->closeCursor();
}
   

function add_category($categoryName){
    global $db;
    #in the statements below, the :names are placeholders, they are filled in later. they could also 
    #be changed to ?, and assigned the same way, but naming them makes keeping track of the
    #assginment easier.
    if($categoryName){
        $query = 'INSERT INTO `categories`(`categoryName`) VALUE (:categoryName)';
    } else {
        return;
    }
    $statement = $db->prepare($query);
    $statement->bindValue(':categoryName', $categoryName);
    $statement->execute();
    #there is no new data to display, so nothing needs to be returned
    $statement->closeCursor();
    return "Successfully Added ".$categoryName."!";
}

function delete_category($categoryID){
    global $db;
    #in the statements below, the :names are placeholders, they are filled in later. they could also 
    #be changed to ?, and assigned the same way, but naming them makes keeping track of the
    #assginment easier.
    if($categoryID){
        $query = 'DELETE FROM `categories` WHERE categoryID = :categoryID';
    } else {
        return;
    }
    $statement = $db->prepare($query);
    $statement->bindValue(':categoryID', $categoryID);
    $statement->execute();
    #there is no new data to display, so nothing needs to be returned
    $statement->closeCursor();
    return "Successfully Deleted Category ".$categoryID."!";
}

function get_category_name($ID){
    global $db;
        $query = 'SELECT categoryName FROM `categories` WHERE categoryID = :categoryID';
    $statement = $db->prepare($query);
    $statement->bindValue(':categoryID', $ID);
    $statement->execute();
    $items = $statement->fetch();
    $statement->closeCursor();
    return $items;
}
?>
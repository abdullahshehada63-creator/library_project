<?php 
include "headerPart.php";
?>

<style>
.books-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 20px;
}
.book-card {
    background: white;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: transform 0.3s;
}
.book-card:hover {
    transform: translateY(-5px);
}
.book-cover {
    width: 100%;
    height: 200px;
    object-fit: cover;
}
.book-info {
    padding: 15px;
}
.book-title {
    font-weight: bold;
    margin-bottom: 5px;
    color: #333;
}
.book-author {
    color: #666;
    font-size: 14px;
    margin-bottom: 10px;
}
.book-actions {
    display: flex;
    gap: 5px;
    padding: 10px;
    border-top: 1px solid #eee;
}
.book-actions a {
    flex: 1;
    text-align: center;
    padding: 5px;
    border-radius: 3px;
    font-size: 12px;
}
</style>

<div class="page-header">
    <h1>Library Books
        <a href="newItem.php" class="btn btn-primary pull-right">
            <span class="glyphicon glyphicon-plus"></span> Add New Book
        </a>
    </h1>
</div>

<?php if(isset($_GET['delete']) && !empty($_GET['delete'])): ?>
    <?php
    $item_id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM `items` WHERE `item_id` = $item_id");
    ?>
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        Book deleted successfully.
    </div>
<?php endif; ?>

<div class="books-container">
    <?php
    $items = mysqli_query($conn, "SELECT * FROM `items` ORDER BY item_id DESC");
    while ($row = mysqli_fetch_assoc($items)):
        $item_id = $row['item_id'];
        $src = !empty($row['item_img']) ? $row['item_img'] : 'path/to/default/cover.jpg';
        $itemName = htmlspecialchars($row['item_name']);
        $itemAuthor = htmlspecialchars($row['item_author'] ?? 'Unknown Author');
        $itemDescription = htmlspecialchars($row['item_Description'] ?? 'No description available');
    ?>
    <div class="book-card">
        <img src="<?= $src ?>" class="book-cover" alt="<?= $itemName ?>">
        <div class="book-info">
            <div class="book-title"><?= $itemName ?></div>
            <div class="book-author">By <?= $itemAuthor ?></div>
            <p><?= substr($itemDescription, 0, 100) ?><?= strlen($itemDescription) > 100 ? '...' : '' ?></p>
        </div>
        <div class="book-actions">
            <a href="more_info.php?id=<?= $item_id ?>" class="btn btn-info btn-xs">
                <span class="glyphicon glyphicon-info-sign"></span> Details
            </a>
            <a href="editItem.php?id=<?= $item_id ?>" class="btn btn-warning btn-xs">
                <span class="glyphicon glyphicon-edit"></span> Edit
            </a>
            <a href="?delete=<?= $item_id ?>" class="btn btn-danger btn-xs" 
               onclick="return confirm('Are you sure you want to delete this book?');">
                <span class="glyphicon glyphicon-trash"></span> Delete
            </a>
        </div>
    </div>
    <?php endwhile; ?>
</div>

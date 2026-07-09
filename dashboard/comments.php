<?php
include "headerPart.php";
?>

<style>
  .comments-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 20px;
    margin-top: 20px;
  }

  .comment-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    transition: all 0.3s ease;
  }

  .comment-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
  }

  .comment-header {
    border-bottom: 1px solid #eee;
    padding-bottom: 10px;
    margin-bottom: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .comment-id {
    font-weight: bold;
    color: #555;
    background: #f5f5f5;
    padding: 3px 8px;
    border-radius: 4px;
  }

  .comment-item {
    font-weight: bold;
    color: #2c3e50;
    margin: 10px 0;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .comment-item-name {
    color: #3498db;
  }

  .comment-text {
    line-height: 1.6;
    color: #333;
    padding: 10px;
    background: #f9f9f9;
    border-radius: 4px;
    border-left: 3px solid #3498db;
  }

  .page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid #eee;
  }

  @media (max-width: 768px) {
    .comments-container {
      grid-template-columns: 1fr;
    }
  }
</style>

<div class="page-header">
  <h2 style="margin: 0;">Comments Management</h2>
</div>

<div class="comments-container">
  <?php
  $comments = mysqli_query($conn, "SELECT comments.*, items.item_name, items.item_id 
                                       FROM `comments` 
                                       JOIN `items` ON comments.product_id = items.item_id
                                       ORDER BY comments.id DESC");
  while ($row = mysqli_fetch_assoc($comments)):
    ?>
    <div class="comment-card">
      <div class="comment-header">
        <span class="comment-id">ID: <?= htmlspecialchars($row['id']) ?></span>
      </div>

      <div class="comment-item">
        On Item:
        <a href="more_info.php?id=<?= $row['item_id'] ?>">
          <span class="comment-item-name"><?= htmlspecialchars($row['item_name']) ?></span>
        </a>
      </div>

      <div class="comment-text">
        <?= nl2br(htmlspecialchars($row['comment'])) ?>
      </div>

      <?php if (isset($row['created_at'])): ?>
        <div style="margin-top: 15px; font-size: 12px; color: #777;">
          Posted on: <?= date('M j, Y g:i a', strtotime($row['created_at'])) ?>
        </div>
      <?php endif; ?>
    </div>
  <?php endwhile; ?>
</div>

<?php
include "footerPart.php";
?>
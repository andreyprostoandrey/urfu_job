<div class="pagination">
    <?php for ($page = 1; $page <= $total_pages; $page++): ?>
        <a href="?page=<?php echo $page; ?>" class="<?php echo ($page === $current_page) ? 'active' : ''; ?>">
            <?php echo $page; ?>
        </a>
    <?php endfor; ?>
    </div>
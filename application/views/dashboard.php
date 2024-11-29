<?php if($logged_in): ?>
    <?php if($role === 'admin'): ?>
        <p>Admin</p>
    <?php elseif($role === 'guest'): ?>
        <p>Guest</p>
    <?php endif; ?>


<?php endif; ?>
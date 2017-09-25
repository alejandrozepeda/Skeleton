<h1>Users</h1>
<ul>
    <?php foreach ($users as $user): ?>
        <li><?php echo $user['id']; ?> - <?php echo $user['name']; ?></li>
    <?php endforeach; ?>
</ul>
<h1>Edit user</h1>

<form action="/users/<?php echo $user['id']; ?>" method="post">
    <input name="name" type="text" placeholder="Name" value="<?php echo $user['name']; ?>">
    <input name="email" type="email" placeholder="Email" value="<?php echo $user['email']; ?>">
    <input name="password" type="password" placeholder="Password">
    <button type="submit">Save</button>
</form>

<?php
$title = 'Categories';
include resource_path('views/header.php');
?>
    <h1 class="mb-4">Categories</h1>
    <a class="btn btn-primary btn-sm mb-2" href="<?= route('categories.create') ?>">Create Category</a>
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Parent</th>
                <th>Date</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $cat) : ?>
            <tr>
                <td><?= $cat->id ?></td>
                <td><?= $cat->name ?></td>
                <td><?= $cat->parent_id ?></td>
                <td><?= $cat->created_at ?></td>
                <td>
                    <a href="<?= route('categories.edit', [$cat->id]) ?>">Edit</a>
                    <form method="post" action="<?= route('categories.delete', [$cat->id]) ?>">
                        <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                        <input type="hidden" name="_method" value="delete">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <?php include resource_path('views/footer.php'); ?>
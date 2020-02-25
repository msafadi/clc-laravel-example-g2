<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <div class="container">
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
    </div>
</body>
</html>
<?php include resource_path('views/header.php'); ?>

<h1 class="mb-4">Categories</h1>

<form method="post" action="<?= route('categories.store') ?>?name=Women">
    <input type="hidden" name="_token" value="<?= csrf_token() ?>">
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" class="form-control" id="name">
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" class="form-control" id="description"></textarea>
    </div>
    <div class="form-group">
        <label for="parent_id">Category Parent</label>
        <select name="parent_id" id="parent_id" class="form-control">
            <option value="">No Parent</option>
            <?php foreach (App\Category::all() as $cat) : ?>
                <option value="<?= $cat->id ?>"><?= $cat->name ?></option>
            <?php endforeach ?>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Create</button>
</form>

<?php include resource_path('views/footer.php'); ?>
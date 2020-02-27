<?php include resource_path('views/header.php'); ?>
        <h1 class="mb-4">Categories</h1>

        <form method="post" action="<?= route('categories.update', [$category->id]) ?>">
            <input type="hidden" name="_token" value="<?= csrf_token() ?>">
            <input type="hidden" name="_method" value="put">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" id="name" value="<?= $category->name ?>">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" class="form-control" id="description"><?= $category->description ?></textarea>
            </div>
            <div class="form-group">
                <label for="parent_id">Category Parent</label>
                <select name="parent_id" id="parent_id" class="form-control">
                    <option value="">No Parent</option>
                    <?php foreach(App\Category::all() as $cat) : ?>
                    <option value="<?= $cat->id ?>" <?php if($cat->id == $category->parent_id) : ?> selected <?php endif ?>><?= $cat->name ?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>

        <?php include resource_path('views/header.php'); ?>
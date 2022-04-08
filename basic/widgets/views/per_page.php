Per page: <select name='per-page' onchange='location = this.value;'>
    <?php foreach ($links as $key => $url) : ?>
        <option <?= $key == $selected ? ' selected="selected"' : '' ?>value='<?= $url ?>'><?= $key ?></option>
    <?php endforeach; ?>
</select>
<form action="<?= esc_url(home_url('/')) ?>" method="get">
    <div class="form-group">
        <label for="search-term"><?= esc_html__('Search') ?></label>
        <input type="search" name="s" id="search-term" class="form-control" value="<?= esc_attr(get_search_query()) ?>">
    </div>

    <button type="submit" class="btn btn-primary"><?= esc_html__('Search') ?></button>
</form>

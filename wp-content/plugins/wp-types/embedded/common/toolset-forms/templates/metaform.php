<div class="wpt-field">
    <?php foreach( $fields as $field ): ?>
    <div class="wpt-field-item">
        <?php if ( !empty($field['repetitive']) ): ?>
        <div class="js-drag"></div>
        <div class="js-delete"></div>
        <?php endif; ?>
        <?php echo $field['html']; ?>
    </div>
    <?php endforeach; ?>
    <?php if ( !empty($field['repetitive']) ): ?>
    <a href="#" class="js-wpt-forms-rep-ctl button-primary" data-wpt-field="<?php echo $field['id']; ?>">Add new field</a>
    <?php endif; ?>
</div>
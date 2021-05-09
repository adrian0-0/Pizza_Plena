<select name="hnwaar[<?php echo $name; ?>]">
<?php foreach( $items as $k => $v) : ?>
	<option value="<?php echo $k; ?>" <?php selected($k, $value) ?>><?php echo $v; ?></option>
<?php endforeach ?>
</select>
<p><?php echo $message ?></p>
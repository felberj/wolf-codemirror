<?php if (!defined('IN_CMS')) { exit(); } ?>

<h1><?php echo __('Settings'); ?></h1>

<form action="<?php echo get_url('plugin/codemirror/save'); ?>" method="post">
	<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="label"><label for="cmintegrate"><?php echo __('Integrate:'); ?> </label></td>
			<td class="field"><input name="cmintegrate" id="cmintegrate" type="checkbox" <?php echo ($file_manager ? 'checked="true"' : ''); ?>/></td>
			<td class="help"><?php echo __('Integrate with <strong>File Manager</strong> plugin.'); ?></td>
		</tr>
	</table>
	<p class="buttons">
        <input class="button" name="commit" type="submit" accesskey="s" value="<?php echo __('Save');?>" />
    </p>
</form>

{combine_css path=$FSRMP_PATH|@cat:"admin/template/style.css"}

{footer_script}
jQuery('input[name="option2"]').change(function() {
  $('.option1').toggle();
});

jQuery(".showInfo").tipTip({
  delay: 0,
  fadeIn: 200,
  fadeOut: 200,
  maxWidth: '300px',
  defaultPosition: 'bottom'
});
{/footer_script}


<div class="titrePage">
	<h2>Fsrmp</h2>
</div>

<div style="margin:1em; padding:1em; text-align:left;">
<p>
{'Here you can predefine two filters to grab pictures list on your server, using Linux <em>find</em> command:'|translate} <strong style="white-space: pre; font-family: monospace;">find -L /path/to/galleries -type f -mmin 60</strong>.<br />
<strong style="white-space: pre; font-family: monospace;">-mmin -60</strong> {'to grab files modified within lastest 60 minutes;'|translate}<br />
<strong style="white-space: pre; font-family: monospace;">-mtime -7</strong> {'to grab files modified within lastest 7 days;'|translate}<br />
<strong style="white-space: pre; font-family: monospace;">-L</strong> {'to follow symlinks;'|translate}<br />
<strong style="white-space: pre; font-family: monospace;">-type f</strong> {'to list files;'|translate}<br />
 {'check your man page.'|translate}<br />
</p>
</div>

<form method="post" action="" class="properties">
<fieldset>
	<legend><input type="checkbox" name="FSRMPPLUGIN_VAR_ENABLED_FILTERS[]" value="f1" {if in_array('f1', $fsrmp.enabled_filters)}checked="checked"{/if} /> {'First filter'|translate}</legend>
    <label>{'Since'|translate}
	   <input type="text" name="FSRMPPLUGIN_VAR_NB1" value="{$fsrmp.nb1}" size="2" />
    </label>
    <label>
		{html_options name=FSRMPPLUGIN_VAR_UNIT1 options=$select_options selected=$fsrmp.unit1}
    </label>
</fieldset>
<fieldset>
	<legend><input type="checkbox" name="FSRMPPLUGIN_VAR_ENABLED_FILTERS[]" value="f2" {if in_array('f2', $fsrmp.enabled_filters)}checked="checked"{/if} /> {'Second filter'|translate}</legend>
    <label>{'Since'|translate}
	   <input type="text" name="FSRMPPLUGIN_VAR_NB2" value="{$fsrmp.nb2}" size="2" />
    </label>
    <label>
		{html_options name=FSRMPPLUGIN_VAR_UNIT2 options=$select_options selected=$fsrmp.unit2}
    </label>
</fieldset>
<fieldset>
	<legend><input type="checkbox" name="FSRMPPLUGIN_VAR_ENABLED_FILTERS[]" value="f3" {if in_array('f3', $fsrmp.enabled_filters)}checked="checked"{/if} /> {'Third filter'|translate}</legend>
	<label>{'Since the latest batch manager metadata update.'|translate} ({'with'|translate} {$fsrmp.batch_manager_metadata.pictures_nb} {'pictures'|translate})</br/>
	{'Since about'|translate} <strong>{$fsrmp_bm_mmin} {'mmin'|translate}{if 1<$fsrmp_bm_mmin}s{/if}</strong>  ({'or since about'|translate} {$fsrmp_bm_mtime} {'mtime'|translate}{if 1<$fsrmp_bm_mtime}s{/if}).</br>{'Due to ceiling of time interval, some updated pictures may remain in the filter.'|translate}</label>
</fieldset>
 
<p class="formButtons"><input type="submit" name="save_config" value="{'Save Settings'|translate}"></p>
</form> 

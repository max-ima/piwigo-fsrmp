<div class="titrePage">
  <h2>Filter system recently modified pictures plugin</h2>
</div>
<p style="text-align:left;">
Configuration de Filter system recently modified pictures plugin<br />
Here you can predefine two threshold to grab pictures on your server using Linux <em>find</em> command: <strong style="white-space: pre; font-family: monospace;">find -L /path/to/pictures -type f -mmin 60</strong>.<br />
<strong style="white-space: pre; font-family: monospace;">-L</strong> to follow symlinks;<br />
<strong style="white-space: pre; font-family: monospace;">-mmin -60</strong> to grab files modified within lastest 60 minutes;<br />
<strong style="white-space: pre; font-family: monospace;">-mtime -1</strong> to grab files modified within lastest 7 days;<br />
</p>
<form method="post" action="{$FSRMPPLUGIN_F_ACTION}" class="general">
<fieldset>
	<legend>First threshold</legend>
    <label>Number
	   <input type="text" name="FSRMPPLUGIN_VAR1D" value="{$FSRMPPLUGIN_VAR1D}" size="2" />
    </label>
    <label>
		{html_options name=FSRMPPLUGIN_VAR1U options=$myOptions selected=$mySelect1}
		Unit
    </label>
</fieldset>
<fieldset>
	<legend>Second threshold</legend>
    <label>Number 
	   <input type="text" name="FSRMPPLUGIN_VAR2D" value="{$FSRMPPLUGIN_VAR2D}" size="2" />
    </label>
    <label>
		{html_options name=FSRMPPLUGIN_VAR2U options=$myOptions selected=$mySelect2}
		Unit
    </label>
</fieldset>
 
<p><input type="submit" value="Enregistrer" name="submit" /></p>
</form> 

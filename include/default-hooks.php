<?php
class LT_DefaultScripts
{
	public function __construct()
	{
		$this->AddActions();
	}
	protected function AddActions()
	{
		SB_Module::add_action('scripts', array($this, 'default_scripts'));
	}
	public function default_scripts()
	{
		$format = array(
				'Y-m-d' => 'yyyy-mm-dd',
				'd-m-Y' => 'dd-mm-yyyy',
				'm-d-Y' => 'mm-dd-yyyy'
		);
		list($lang,) = explode('_', LANGUAGE);
		$globals = SB_Module::do_action('lt_js_globals', array(
				'baseurl' 			=> BASEURL,
				'lang'				=> $lang,
				'dateformat'		=> $format[DATE_FORMAT]
		));
		?>
		<script>var lt = <?php print json_encode($globals); ?>;</script>
		<?php 
	}
}
new LT_DefaultScripts();
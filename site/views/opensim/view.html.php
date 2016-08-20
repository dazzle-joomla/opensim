<?php
/*
 * @component jOpenSim
 * @copyright Copyright (C) 2015 FoTo50 http://www.jopensim.com/
 * @license GNU/GPL v2 http://www.gnu.org/licenses/gpl-2.0.html
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

$_REQUEST['tmpl'] = "component";

class opensimViewopensim extends JViewLegacy {

	public function display($tpl = null) {
		$_SERVER['HTTP_USER_AGENT'] = "opensimviewer";

		$model = $this->getModel('opensim');

		$this->gridstatus = $model->getGridStatus();

		$this->assetpath = JUri::base(true)."/components/com_opensim/assets/";
		$doc = JFactory::getDocument();
		$doc->addStyleSheet($this->assetpath.'opensim.css');
		$doc->addStyleSheet($this->assetpath.'opensim.override.css');

		$regions = $model->getData();
		$this->settingsdata = $model->getSettingsData();

		if(intval($this->settingsdata['hiddenregions']) == 0) {
			$regionarray = $model->removehidden($regions['regions']);
		} else {
			$regionarray = $regions['regions'];
		}
		$this->assignRef('regions',$regionarray);

		$this->assignRef('mapserver',$this->settingsdata['oshost']);
		$this->assignRef('mapport',$this->settingsdata['osport']);

		$this->totalusers	= $model->opensim->countActiveUsers();

		$task = JFactory::getApplication()->input->get( 'task', '', 'method', 'string');
		switch($task) {
			default:
			break;
		}

		parent::display($tpl);
	}
}
?>
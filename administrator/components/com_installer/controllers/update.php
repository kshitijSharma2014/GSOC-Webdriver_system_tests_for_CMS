<?php
/**
 * @version		$Id: controller.php 13265 2009-10-21 10:08:19Z eddieajau $
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License, see LICENSE.php
 */

// No direct access
defined('_JEXEC') or die;

class InstallerControllerUpdate extends JController {
	// Should probably use multiple controllers here
	function update()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit(JText::_('JInvalid_Token'));

		$model	= &$this->getModel('update');

		$uid = JRequest::getVar('uid', array(), '', 'array');

		JArrayHelper::toInteger($uid, array());
		if ($model->update($uid))
		{
			$cache = &JFactory::getCache('mod_menu');
			$cache->clean();
		}
		$model->saveState(); // Save the state because this is where our messages are stored
		$this->setRedirect('index.php?option=com_installer&view=install');
	}

	function find()
	{
		// Find updates
		// Check for request forgeries
		JRequest::checkToken() or jexit(JText::_('JInvalid_Token'));
		$model	= &$this->getModel('update');
		$model->purge();
		$result = $model->findUpdates();
		$this->setRedirect('index.php?option=com_installer&view=update');
		//$view->display();
	}

	function purge()
	{
		// Purge updates
		// Check for request forgeries
		JRequest::checkToken() or jexit(JText::_('JInvalid_Token'));
		$model = &$this->getModel('update');
		$model->purge();
		$this->setRedirect('index.php?option=com_installer&view=update', $model->_message);
	}
}
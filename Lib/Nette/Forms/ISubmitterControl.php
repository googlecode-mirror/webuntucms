<?php

/**
 * Nette Framework
 *
 * Copyright (c) 2004, 2008 David Grudl (http://davidgrudl.com)
 *
 * This source file is subject to the "Nette license" that is bundled
 * with this package in the file license.txt.
 *
 * For more information please see http://nettephp.com
 *
 * @copyright  Copyright (c) 2004, 2008 David Grudl
 * @license    http://nettephp.com/license  Nette license
 * @link       http://nettephp.com
 * @category   Nette
 * @package    Nette\Forms
 * @version    $Id: ISubmitterControl.php 110 2008-11-10 14:10:29Z david@grudl.com $
 */

/*namespace Nette\Forms;*/



require_once dirname(__FILE__) . '/../Forms/IFormControl.php';



/**
 * Defines method that must be implemented to allow a control to submit web form.
 *
 * @author     David Grudl
 * @copyright  Copyright (c) 2004, 2008 David Grudl
 * @package    Nette\Forms
 */
interface ISubmitterControl extends IFormControl
{

	/**
	 * Tells if the form was submitted by this button.
	 * @return bool
	 */
	function isSubmittedBy();

	/**
	 * Gets the validation scope. Clicking the button validates only the controls within the specified scope.
	 * @return mixed
	 */
	function getValidationScope();

}
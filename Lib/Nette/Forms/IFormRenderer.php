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
 * @version    $Id: IFormRenderer.php 110 2008-11-10 14:10:29Z david@grudl.com $
 */

/*namespace Nette\Forms;*/



/**
 * Defines method that must implement form rendered.
 *
 * @author     David Grudl
 * @copyright  Copyright (c) 2004, 2008 David Grudl
 * @package    Nette\Forms
 */
interface IFormRenderer
{

	/**
	 * Provides complete form rendering.
	 * @param  Form
	 * @return string
	 */
	function render(Form $form);

}

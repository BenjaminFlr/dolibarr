<?php

/* Copyright (C) 2003-2004 Rodolphe Quiedeville <rodolphe@quiedeville.org>
 * Copyright (C) 2004-2005 Laurent Destailleur  <eldy@users.sourceforge.net>
 * Copyright (C) 2004      Eric Seigne          <eric.seigne@ryxeo.com>
 * Copyright (C) 2005-2012 Regis Houssin        <regis.houssin@inodbox.com>
 * Copyright (C) 2006      Andre Cianfarani     <acianfa@free.fr>
 * Copyright (C) 2011-2016 Philippe Grand       <philippe.grand@atoo-net.com>
 * Copyright (C) 2014      Marcos García        <marcosgdf@gmail.com>
 * Copyright (C) 2024-2025	MDW						<mdeweerd@users.noreply.github.com>
 * Copyright (C) 2024       Frédéric France         <frederic.france@free.fr>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 * or see https://www.gnu.org/
 */

/**
 *		\file       htdocs/core/modules/supplier_order/modules_commandefournisseur.php
 *      \ingroup    supplier order
 *      \brief      File that contains parent class for supplier orders models
 *                  and parent class for supplier orders numbering models
 */
require_once DOL_DOCUMENT_ROOT.'/core/class/commondocgenerator.class.php';
require_once DOL_DOCUMENT_ROOT.'/core/class/commonnumrefgenerator.class.php';
require_once DOL_DOCUMENT_ROOT.'/compta/bank/class/account.class.php'; // required for use by classes that inherit


/**
 *	Parent class for supplier orders models
 */
abstract class ModelePDFSuppliersOrders extends CommonDocGenerator
{
	/**
	 * @var float
	 */
	public $posxpicture;
	/**
	 * @var float
	 */
	public $posxtva;
	/**
	 * @var float
	 */
	public $posxup;
	/**
	 * @var float
	 */
	public $posxqty;
	/**
	 * @var float
	 */
	public $posxunit;
	/**
	 * @var float
	 */
	public $posxdesc;
	/**
	 * @var float
	 */
	public $posxdiscount;
	/**
	 * @var float
	 */
	public $postotalht;

	/**
	 * @var array<string,float>
	 */
	public $tva;
	/**
	 * @var array<string,array{amount:float}>
	 */
	public $tva_array;
	/**
	 * Local tax rates Array[tax_type][tax_rate]
	 *
	 * @var array<int,array<string,float>>
	 */
	public $localtax1;
	/**
	 * Local tax rates Array[tax_type][tax_rate]
	 *
	 * @var array<int,array<string,float>>
	 */
	public $localtax2;

	/**
	 * @var int<0,1>
	 */
	public $atleastoneratenotnull = 0;
	/**
	 * @var int<0,1>
	 */
	public $atleastonediscount = 0;

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Return list of active generation modules
	 *
	 *  @param  DoliDB  	$db                 Database handler
	 *  @param  int<0,max>	$maxfilenamelength  Max length of value to show
	 *  @return string[]|int<-1,0>				List of templates
	 */
	public static function liste_modeles($db, $maxfilenamelength = 0)
	{
		// phpcs:enable
		$type = 'order_supplier';
		$list = array();

		include_once DOL_DOCUMENT_ROOT.'/core/lib/functions2.lib.php';
		$list = getListOfModels($db, $type, $maxfilenamelength);

		return $list;
	}


	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *	Function to build document
	 *
	 *	@param	CommandeFournisseur	$object				Object source to generate (or id if old method)
	 *	@param	Translate			$outputlangs		Lang output object
	 *	@param	string				$srctemplatepath	Full path of source filename for generator using a template file
	 *	@param	int<0,1>			$hidedetails		Do not show line details
	 *	@param	int<0,1>			$hidedesc			Do not show desc
	 *	@param	int<0,1>			$hideref			Do not show ref
	 *	@return	int<-1,1>								1 if OK, <=0 if KO
	 */
	abstract public function write_file($object, $outputlangs, $srctemplatepath = '', $hidedetails = 0, $hidedesc = 0, $hideref = 0);
}



/**
 *	Parent Class of numbering models of supplier order references
 */
abstract class ModeleNumRefSuppliersOrders extends CommonNumRefGenerator
{
	/**
	 * 	Return next value
	 *
	 *  @param	Societe|string		$objsoc		Object third party
	 *  @param  CommandeFournisseur	$object		Object
	 *  @return string|int<-1,0>				Value if OK, <=0 if KO
	 */
	abstract public function getNextValue($objsoc, $object);

	/**
	 *  Return an example of numbering
	 *
	 *  @return     string      Example
	 */
	abstract public function getExample();
}

<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Leo Feyer 2005-2011, Mario Müller 2012
 * @author     Leo Feyer <http://www.contao.org>, Mario Müller <http://www.lingo4u.de>
 * @package    Glossary
 * @license    LGPL
 * @filesource
 */


/**
 * Load tl_content language file
 */
$this->loadLanguageFile('tl_content');


/**
 * Table tl_glossary_term
 */
$GLOBALS['TL_DCA']['tl_glossary_term'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ptable'                      => 'tl_glossary',
		'enableVersioning'            => true,
		'onsubmit_callback'           => array(
			array('tl_glossary_term', 'submitTerm')
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 4,
			'flag'                    => 1,
			'fields'                  => array('sortTerm'),
			'headerFields'            => array('title', 'tstamp'),
			'panelLayout'             => 'filter;search,limit',
			'child_record_callback'   => array('tl_glossary_term', 'listTerms')
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset();" accesskey="e"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_glossary_term']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_glossary_term']['copy'],
				'href'                => 'act=paste&amp;mode=copy',
				'icon'                => 'copy.gif'
			),
			'cut' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_glossary_term']['cut'],
				'href'                => 'act=paste&amp;mode=cut',
				'icon'                => 'cut.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_glossary_term']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_glossary_term']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array('addReference', 'addExample', 'addImage', 'addEnclosure'),
		'default'                     => '{title_legend},term,author;{reference_legend:hide},addReference;{definition_legend},definition;{example_legend:hide},addExample;{image_legend},addImage;{enclosure_legend:hide},addEnclosure'
	),

	// Subpalettes
	'subpalettes' => array
	(
		'addReference'                => 'referenceTerm,referenceType',
		'addExample'                  => 'example',
		'addImage'                    => 'singleSRC,alt,size,imagemargin,imageUrl,fullsize,caption,floating',
		'addEnclosure'                => 'enclosure'
	),

	// Fields
	'fields' => array
	(
		'term' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_glossary_term']['term'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
			'save_callback' => array
			(
				array('tl_glossary_term', 'capitalizeTerm')
			)
		),
		'author' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_glossary_term']['author'],
			'default'                 => $this->User->id,
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'select',
			'foreignKey'              => 'tl_user.name',
			'eval'                    => array('doNotCopy'=>true, 'mandatory'=>true, 'includeBlankOption'=>true, 'tl_class'=>'w50')
		),
		'addReference' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_glossary_term']['addReference'],
			'exclude'			=> true,
			'inputType'			=> 'checkbox',
			'eval'				=> array('submitOnChange'=>true)
		),
		'referenceTerm' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_glossary_term']['referenceTerm'],
			'exclude'			=> true,
			'inputType'			=> 'select',
			'options_callback'	=> array('tl_glossary_term', 'getParentTerms'),
			'eval'				=> array(
				'chosen'=>true,
				'tl_class'=>'w50'
			)
		),
		'referenceType' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_glossary_term']['referenceType']['title'],
			'exclude'			=> true,
			'inputType'			=> 'select',
			'options'				  => array('parent', 'reference'),
			'reference'				  => &$GLOBALS['TL_LANG']['tl_glossary_term']['referenceType']['reference'],
			'eval'				=> array(
				'tl_class'=>'w50'
			)
		),
		'definition' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_glossary_term']['definition'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('mandatory'=>false, 'rte'=>'tinyMCE', 'helpwizard'=>true),
			'explanation'             => 'insertTags'
		),
		'addExample' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_glossary_term']['addExample'],
			'exclude'			=> true,
			'inputType'			=> 'checkbox',
			'eval'				=> array('submitOnChange'=>true)
		),
		'example' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_glossary_term']['example'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('mandatory'=>false, 'rte'=>'tinyMCE', 'helpwizard'=>true),
			'explanation'             => 'insertTags'
		),
		'addImage' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_glossary_term']['addImage'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>true)
		),
		'singleSRC' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_content']['singleSRC'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'mandatory'=>true)
		),
		'alt' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_content']['alt'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'long')
		),
		'size' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_content']['size'],
			'exclude'                 => true,
			'inputType'               => 'imageSize',
			'options'                 => array('crop', 'proportional', 'box'),
			'reference'               => &$GLOBALS['TL_LANG']['MSC'],
			'eval'                    => array('rgxp'=>'digit', 'nospace'=>true, 'tl_class'=>'w50')
		),
		'imagemargin' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_content']['imagemargin'],
			'exclude'                 => true,
			'inputType'               => 'trbl',
			'options'                 => array('px', '%', 'em', 'pt', 'pc', 'in', 'cm', 'mm'),
			'eval'                    => array('includeBlankOption'=>true, 'tl_class'=>'w50')
		),
		'imageUrl' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_content']['imageUrl'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'url', 'decodeEntities'=>true, 'maxlength'=>255, 'tl_class'=>'w50 wizard'),
			'wizard' => array
			(
				array('tl_glossary_term', 'pagePicker')
			)
		),
		'fullsize' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_content']['fullsize'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'=>'w50 m12')
		),
		'caption' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_content']['caption'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50')
		),
		'floating' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_content']['floating'],
			'exclude'                 => true,
			'inputType'               => 'radioTable',
			'options'                 => array('above', 'left', 'right', 'below'),
			'eval'                    => array('cols'=>4, 'tl_class'=>'w50'),
			'reference'               => &$GLOBALS['TL_LANG']['MSC']
		),
		'addEnclosure' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_glossary_term']['addEnclosure'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>true)
		),
		'enclosure' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_glossary_term']['enclosure'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('fieldType'=>'checkbox', 'files'=>true, 'filesOnly'=>true, 'mandatory'=>true)
		)
	)
);


/**
 * Class tl_glossary_term
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Leo Feyer 2008-2011
 * @author     Leo Feyer <http://www.contao.org>
 * @package    Controller
 */
class tl_glossary_term extends Backend
{

	public function __construct()
	{
		parent::__construct();
	}


	/**
	 * Capitalize a term
	 * @param string
	 * @return string
	 */
	public function capitalizeTerm($term)
	{
		$first = utf8_substr($term, 0, 1);
		$upper = utf8_strtoupper($first);

		return $upper . utf8_substr($term, 1);
	}


	public function listTerms($arrRow)
	{
		$strReturn = $arrRow['term'];

		if ($arrRow['addReference'] == '1')
		{
			if ($arrRow['referenceType'] == 'parent')
			{
				$strReturn = '<span style="padding-left:1em">» ' . $arrRow['term'] . '</span>';
			}
			elseif ($arrRow['referenceType'] == 'reference')
			{
				$objTerm = $this->Database->prepare("SELECT `term` FROM `tl_glossary_term` WHERE `id`=?")
					->limit(1)
					->execute
					(
						$arrRow['referenceTerm']
					);
				
				if ($objTerm->next())
				{
					$strReturn = $arrRow['term'] . ' → <em>' . $objTerm->term . '</em>';
				}
			}
		}

		return $strReturn;
	}


	public function submitTerm(DataContainer $dc)
	{
		$sortTerm = $dc->activeRecord->term;

		if ($dc->activeRecord->addReference == '1' && $dc->activeRecord->referenceType == 'parent')
		{
			$objTerm = $this->Database->prepare("SELECT `id`,`term` FROM `tl_glossary_term` WHERE `id`=?")
				->limit(1)
				->execute
				(
					$dc->activeRecord->referenceTerm
				);

			if ($objTerm->next())
			{
				$sortTerm = $objTerm->term.'-'.$dc->activeRecord->term;
			}
		}
		elseif ($dc->activeRecord->addReference == '')
		{
			$objTerms = $this->Database->prepare("SELECT `id`,`term` FROM `tl_glossary_term` WHERE `addReference`='1' AND `referenceType`='parent' AND `referenceTerm`=?")
				->execute(
					$dc->activeRecord->id
				);
			
			while ($objTerms->next())
			{
				$this->Database->prepare("UPDATE `tl_glossary_term` SET `sortTerm`=? WHERE `id`=?")
					->execute
					(
						$dc->activeRecord->term.'-'.$objTerms->term,
						$objTerms->id
					);
			}
		}
		
		if (preg_match_all('|({{glossary::)([^}]+)(}})|isUm', $dc->activeRecord->definition, $matches, PREG_SET_ORDER))
		{
			foreach ($matches as $match)
			{
				if ((int)$match[2] == 0)
				{
					$objTerm = $this->Database->prepare("SELECT `id` FROM `tl_glossary_term` WHERE `term`=?")
						->limit(1)
						->execute($match[2]);
					
					if ($objTerm->next())
					{
						$dc->activeRecord->definition = str_replace($match[0], $match[1].$objTerm->id.$match[3], $dc->activeRecord->definition);
					}
				}
			}
		}
		
		$this->Database->prepare("UPDATE `tl_glossary_term` SET `sortTerm`=?, `definition`=? WHERE `id`=?")
			->execute(
				$sortTerm,
				$dc->activeRecord->definition,
				$dc->activeRecord->id
			);
	}


	public function getParentTerms()
	{
		$arrTerms = array();

		$objTerms = $this->Database->prepare("SELECT `id`,`term` FROM `tl_glossary_term` WHERE `addReference`='' ORDER by `term`")->execute();

		while ($objTerms->next())
		{
			$arrTerms[$objTerms->id] = $objTerms->term;
		}

		return $arrTerms;
	}


	/**
	 * Return the link picker wizard
	 * @param object
	 * @return string
	 */
	public function pagePicker(DataContainer $dc)
	{
		$strField = 'ctrl_' . $dc->field . (($this->Input->get('act') == 'editAll') ? '_' . $dc->id : '');
		return ' ' . $this->generateImage('pickpage.gif', $GLOBALS['TL_LANG']['MSC']['pagepicker'], 'style="vertical-align:top; cursor:pointer;" onclick="Backend.pickPage(\'' . $strField . '\')"');
	}
}

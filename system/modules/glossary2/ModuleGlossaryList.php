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
 * @copyright  Leo Feyer 2005-2011
 * @author     Leo Feyer <http://www.contao.org>
 * @package    Glossary
 * @license    LGPL
 * @filesource
 */


/**
 * Class ModuleGlossaryList
 *
 * @copyright  Leo Feyer 2008-2011
 * @author     Leo Feyer <http://www.contao.org>
 * @package    Controller
 */
class ModuleGlossaryList extends Module
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_glossary_list';


	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### GLOSSARY LIST ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=modules&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}

		$this->glossaries = deserialize($this->glossaries);

		// Return if there are no glossaries
		if (!is_array($this->glossaries) || count($this->glossaries) < 1)
		{
			return '';
		}

		return parent::generate();
	}
	

	/**
	 * Generate module
	 */
	protected function compile()
	{
		$objTerm = $this->Database->execute("SELECT * FROM tl_glossary_term WHERE pid IN(" . implode(',', array_map('intval', $this->glossaries)) . ")" . " ORDER BY sortTerm");

		if ($objTerm->numRows < 1)
		{
			$this->Template->terms = array();
			return;
		}

		global $objPage;
		$this->import('String');
		$arrTerms = array();

		while ($objTerm->next())
		{
			$objTemp = new stdClass();
			$key = utf8_strtoupper(utf8_substr($objTerm->sortTerm, 0, 1));

			$objTemp->term = $objTerm->term;
			$objTemp->anchor = 'gl' . utf8_romanize($key);
			$objTemp->id = standardize($objTerm->term);
			
			$objTemp->isParent = false;
			$objTemp->isReference = false;
			
			if ($objTerm->addReference)
			{
				if ($objTerm->referenceType == 'parent')
				{
					$objTemp->hasParent = true;
				}
				elseif ($objTerm->referenceType == 'reference')
				{
					$objTemp->isReference = true;
					$objTemp->referenceTerm = false;
					
					$objReference = $this->Database->prepare("SELECT `id`,`term` FROM `tl_glossary_term` WHERE `id`=?")->execute($objTerm->referenceTerm);
					if ($objReference->next())
					{
						$objTemp->referenceTerm = $objReference->term;
						$objTemp->referenceAnchor = standardize($objReference->term);
					}
				}
			}

			// Clean the RTE output
			if ($objPage->outputFormat == 'xhtml')
			{
				$objTerm->definition = $this->String->toXhtml($objTerm->definition);
			}
			else
			{
				$objTerm->definition = $this->String->toHtml5($objTerm->definition);
			}

			$objTemp->definition = $this->String->encodeEmail($objTerm->definition);
			
			if ($objTerm->addExample)
			{
				$objTemp->addExample = true;
				$objTemp->example = ($objPage->outputFormat == 'xhtml' ? $this->String->toXhtml($objTerm->example) : $this->String->toHtml5($objTerm->example));
			}
			else
			{
				$objTemp->addExample = false;
			}

			$objTemp->addImage = false;

			// Add image
			if ($objTerm->addImage && is_file(TL_ROOT . '/' . $objTerm->singleSRC))
			{
				$this->addImageToTemplate($objTemp, $objTerm->row());
			}

			$objTemp->enclosures = array();

			// Add enclosures
			if ($objTerm->addEnclosure)
			{
				$this->addEnclosuresToTemplate($objTemp, $objTerm->row());
			}

			$arrTerms[$key][] = $objTemp;
		}

		$this->Template->terms = $arrTerms;
		$this->Template->request = ampersand($this->Environment->request, true);
		$this->Template->topLink = $GLOBALS['TL_LANG']['MSC']['backToTop'];
	}
}

?>
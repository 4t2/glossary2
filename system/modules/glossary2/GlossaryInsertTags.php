<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Class GlossaryInsertTags
 *
 * @copyright  Mario Müller 2012
 * @author     Mario Müller <http://www.lingo4u.de>
 * @package    Controller
 */
class GlossaryInsertTags extends System
{
   public function replaceInsertTags($strTag)
   {
       $arrSplit = explode('::', $strTag);
       
		/*
       		{{glossary::ID}} / {{glossary::Term}}
		*/

		if ($arrSplit[0] == 'glossary' && !empty($arrSplit[1]))
		{
			if ((int)$arrSplit[1] > 0)
			{
				$objTerm = $this->Database->prepare("SELECT `id`,`term` FROM `tl_glossary_term` WHERE `id`=?")
					->limit(1)
					->execute($arrSplit[1]);
				
			}
			else
			{
				$objTerm = $this->Database->prepare("SELECT `id`,`term` FROM `tl_glossary_term` WHERE `term`=?")
					->limit(1)
					->execute($arrSplit[1]);
			}
			
			if ($objTerm->next())
			{
				$this->import('String');				
				return ampersand($this->Environment->request, true).'#'.standardize($objTerm->term);
			}
		}

		return false;
	}
}

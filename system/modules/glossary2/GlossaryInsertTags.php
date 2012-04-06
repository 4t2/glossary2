<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Class GlossaryInsertTags
 *
 * @copyright  Mario Müller 2012
 * @author     Mario Müller <http://www.lingo4u.de>
 * @package    Controller
 */
class GlossaryInsertTags extends Controller
{
	public function replaceGlossaryTags($strTag)
	{
		$arrSplit = explode('::', $strTag);

		/*
       		{{glossary::ID}} / {{glossary::Term}}
		*/

		if ($arrSplit[0] == 'glossary' && !empty($arrSplit[1]))
		{
			global $objPage;
			$this->import('Database');

			$arrGlossaries = array();
			$isGlossaryPage = false;
			$glossaryPageId = 0;

			/* look for glossary module on the current page */
			$objGlossaries = $this->Database->prepare("SELECT `glossaries` FROM `tl_module` WHERE `type`='glossaryList' AND `id` = (SELECT `module` FROM `tl_content` WHERE `type`='module' AND `pid`= (SELECT `id` FROM `tl_article` WHERE `pid`=?))")
				->limit(1)
				->execute($objPage->id);
			
			if ($objGlossaries->next())
			{
				$arrValues = deserialize($objGlossaries->glossaries);
				$arrGlossaries = array_values($arrValues);
				$isGlossaryPage = true;
			}

			if (count($arrGlossaries) == 0)
			{
				/* find first glossary in page hierarchy */
				$objGlossaries = $this->Database->execute("SELECT `id`,`glossaries` FROM `tl_module` WHERE `type`='glossaryList'");
				
				while ($glossaryPageId == 0 && $objGlossaries->next())
				{
					$objArticles = $this->Database->prepare("SELECT `pid` FROM `tl_article` WHERE `published`=1 AND `id` IN (SELECT `pid` FROM `tl_content` WHERE `published`=1 AND `type`='module' AND `module` = ?)")
						->execute($objGlossaries->id);

					while ($glossaryPageId == 0 && $objArticles->next())
					{
						if ($objPage->rootId == $this->getRootPage($objArticles->pid))
						{
							$arrValues = deserialize($objGlossaries->glossaries);
							$arrGlossaries = array_values($arrValues);
							$glossaryPageId = $objArticles->pid;
						}
					}
				}

				$objPages = $this->Database->execute("SELECT `pid` FROM `tl_article` WHERE `published`=1 AND `id` IN (SELECT `pid` FROM `tl_content` WHERE `published`=1 AND `type`='module' AND `module` = (SELECT `id` FROM `tl_module` WHERE `type`='glossaryList'))");
			}

			if (count($arrGlossaries) > 0)
			{
				if ((int)$arrSplit[1] > 0)
				{
					$objTerm = $this->Database->prepare("SELECT `id`,`term` FROM `tl_glossary_term` WHERE `id`=?")
						->limit(1)
						->execute($arrSplit[1]);
					
				}
				else
				{
					$objTerm = $this->Database->prepare("SELECT `id`,`term` FROM `tl_glossary_term` WHERE `term`=? AND `pid` IN (".implode(',', $arrGlossaries).")")
						->limit(1)
						->execute($arrSplit[1]);
				}
				
				if ($objTerm->next())
				{
					$this->import('String');
					
					if ($isGlossaryPage)
					{				
						return ampersand($this->Environment->request, true).'#'.standardize($objTerm->term);
					}
					elseif ($glossaryPageId > 0)
					{
						$objGlossaryPage = $this->Database->prepare("SELECT * FROM `tl_page` WHERE `id`=?")
							->limit(1)
							->execute($glossaryPageId);
	
						if ($objGlossaryPage->next())
						{
							if (version_compare(VERSION, '2.10', '>'))
							{
								$strGlossaryUrl = $this->generateFrontendUrl($objGlossaryPage->row(), null, $objPage->rootLanguage);
							}
							else
							{
								$strGlossaryUrl = $this->generateFrontendUrl($objGlossaryPage->row());
							}
							
							return $strGlossaryUrl.'#'.standardize($objTerm->term);
						}
					}
				}
			}
		}

		return false;
	}


	private function getRootPage($pid)
	{
		$rootId = $pid;
		$pageType = '';

		do
		{
			$objParentPage = $this->Database->prepare("SELECT `id`, `pid`, `type` FROM `tl_page` WHERE id=?")
				->limit(1)
				->execute($pid);
		
			if ($objParentPage->next())
			{
				$rootId = $objParentPage->id;
				$pid = $objParentPage->pid;
				$pageType = $objParentPage->type;
			}
			else
			{
				break;
			}
		}
		while ($pid > 0 && $pageType != 'root');

		return $rootId;
	}

}

<?php
class GlossaryRunonceJob extends Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->import('Database');
	}

	public function run()
	{
		$this->Database->prepare("UPDATE `tl_glossary_term` SET `sortTerm`=`term` WHERE `sortTerm`=''")->execute();
	}
}

$objGlossaryRunonceJob = new GlossaryRunonceJob();
$objGlossaryRunonceJob->run();
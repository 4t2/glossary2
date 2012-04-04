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
 * Fields
 */
$GLOBALS['TL_LANG']['tl_glossary_term']['term']         = array('Begriff', 'Bitte geben Sie den Begriff ein.');
$GLOBALS['TL_LANG']['tl_glossary_term']['author']       = array('Autor', 'Hier können Sie den Autor der Definition ändern.');
$GLOBALS['TL_LANG']['tl_glossary_term']['addReference'] = array('Verweis/Beziehung auf Begriff hinzufügen', 'Verweis/Beziehung auf einen Begriff hinzufügen');
$GLOBALS['TL_LANG']['tl_glossary_term']['referenceTerm'] = array('Begriff', 'Auf diesen Begriff verweisen/beziehen');
$GLOBALS['TL_LANG']['tl_glossary_term']['referenceType']['title'] = array('Beziehung', 'In welcher Beziehung stehen die Begriffe');
$GLOBALS['TL_LANG']['tl_glossary_term']['referenceType']['reference'] = array(
	'parent' => 'Übergeordneter Begriff',
	'reference' => 'Verweis auf diesen Begriff'
);
$GLOBALS['TL_LANG']['tl_glossary_term']['definition']   = array('Definition', 'Bitte geben Sie die Definition ein.');
$GLOBALS['TL_LANG']['tl_glossary_term']['addExample']   = array('Beispiel hinzufügen', 'Ein Beispiel für den Begriff hinzufügen');
$GLOBALS['TL_LANG']['tl_glossary_term']['example']      = array('Beispiel', 'Beispiel für diesen Begriff');
$GLOBALS['TL_LANG']['tl_glossary_term']['addImage']     = array('Ein Bild hinzufügen', 'Der Definition ein Bild hinzufügen.');
$GLOBALS['TL_LANG']['tl_glossary_term']['addEnclosure'] = array('Anlagen hinzufügen', 'Der Definition eine oder mehrere Dateien als Download hinzufügen.');
$GLOBALS['TL_LANG']['tl_glossary_term']['enclosure']    = array('Anlagen', 'Bitte wählen Sie die Dateien aus, die Sie hinzufügen möchten.');


/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_glossary_term']['title_legend']      = 'Begriff und Autor';
$GLOBALS['TL_LANG']['tl_glossary_term']['reference_legend']  = 'Verweis/Beziehung auf einen Begriff';
$GLOBALS['TL_LANG']['tl_glossary_term']['definition_legend'] = 'Definition';
$GLOBALS['TL_LANG']['tl_glossary_term']['example_legend']    = 'Beispiel';
$GLOBALS['TL_LANG']['tl_glossary_term']['image_legend']      = 'Bild-Einstellungen';
$GLOBALS['TL_LANG']['tl_glossary_term']['enclosure_legend']  = 'Anlagen';


/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_glossary_term']['new']    = array('Neuer Begriff', 'Einen neuen Begriff hinzufügen');
$GLOBALS['TL_LANG']['tl_glossary_term']['show']   = array('Begriffsdetails', 'Details des Begriffs ID %s anzeigen');
$GLOBALS['TL_LANG']['tl_glossary_term']['edit']   = array('Begriff bearbeiten', 'Begriff ID %s bearbeiten');
$GLOBALS['TL_LANG']['tl_glossary_term']['cut']    = array('Begriff verschieben', 'Begriff ID %s verschieben');
$GLOBALS['TL_LANG']['tl_glossary_term']['copy']   = array('Begriff duplizieren', 'Begriff ID %s duplizieren');
$GLOBALS['TL_LANG']['tl_glossary_term']['delete'] = array('Begriff löschen', 'Begriff ID %s löschen');

?>
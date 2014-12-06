<?php
# @version		$version 0.1 Amvis United Company Limited  $
# @copyright	Copyright (C) 2014 AUnited Co Ltd. All rights reserved.
# @license		SunStat has been originally created by Vitaliy Zhukov under GNU/GPL and relicensed under Apache v2.0, see LICENSE
# Updated		06th December 2014
#
# Site: http://aunited.ru
# Email: info@aunited.ru
# Phone
#
# Joomla! is free software. This version may have been modified pursuant
# to the GNU General Public License, and as distributed it includes or
# is derivative of works licensed under the GNU General Public License or
# other free or open source software licenses.
# See COPYRIGHT.php for copyright notices and details.

// Assert file included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );


//SunTube Content Plugin


class plgContentSunTubePlugin extends JPlugin
{

	/**
	* Ctor
	*
	* @param object $subject The object to observe
	* @param object $params The object that holds the plugin parameters
	*/
	function PluginSunTube( &$subject, $params )
	{
		parent::__construct( $subject, $params );
	}

	/**
	* Example prepare content method
	*
	* Method is called by the view
	*
	* @param object The article object. Note $article->text is also available
	* @param object The article params
	* @param int The 'page' number
	*/
	function onContentPrepare( $context, &$article, &$params, $page = 0)
		{
		global $mainframe;

		if ( JString::strpos( $article->text, '{youtube}' ) === false ) {
		return true;
		}
		
		$article->text = preg_replace('|{youtube}(.*){\/youtube}|e', '$this->embedVideo("\1")', $article->text);
		return true;
	}

	function embedVideo($vCode)
	{
	 	$params = $this->params;

		$width = $params->get('width', 425);
		$height = $params->get('height', 344);
	
		return '<object width="'.$width.'" height="'.$height.'"><param name="movie" value="http://www.youtube.com/v/'.$vCode.'"></param><param name="allowFullScreen" value="true"></param><embed src="http://www.youtube.com/v/'.$vCode.'" type="application/x-shockwave-flash" allowfullscreen="true" width="'.$width.'" height="'.$height.'"></embed></object>';
	}

}
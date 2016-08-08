<?php
# @version		$version 0.1.1 Amvis United Company Limited  $
# @copyright	Copyright (C) 2016 AUnited Co Ltd. All rights reserved.
# @license		SunTube licensed under Apache v2.0, see LICENSE.md
# Updated		08th August 2016
#
# Site: http://aunited.ru
# Phone
#
// Assert file included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );


//SunTube Content Plugin
class plgContentSunTubePlugin extends JPlugin
{

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

		if ( JString::strpos( $article->text, '{youtube}' ) === false or JString::strpos( $article->text, '{rutube}' ) === false or JString::strpos( $article->text, '{vkvideo}' ) === false or JString::strpos( $article->text, '{vimeo}' ) === false ) {
		return true;
		}
		
		$article->text = preg_replace_callback('|{youtube}(.*){\/youtube}|',function ($match){return $this->yt_embedVideo($match[1]);}, $article->text);
		$article->text = preg_replace_callback('|{rutube}(.*){\/rutube}|',function ($match){return $this->rt_embedVideo($match[1]);}, $article->text);
		$article->text = preg_replace_callback('|{vkvideo}(.*){\/vkvideo}|',function ($match){return $this->vk_embedVideo($match[1]);}, $article->text);
		$article->text = preg_replace_callback('|{vimeo}(.*){\/vimeo}|',function ($match){return $this->vm_embedVideo($match[1]);}, $article->text);
		return true;
	}


	function yt_embedVideo($vCode)
	{
	 	$params = $this->params;

		$width = $params->get('width', 425);
		$height = $params->get('height', 344);
	
		return '<object width="'.$width.'" height="'.$height.'"><param name="movie" value="http://www.youtube.com/v/'.$vCode.'"></param><param name="allowFullScreen" value="true"></param><embed src="http://www.youtube.com/v/'.$vCode.'" type="application/x-shockwave-flash" allowfullscreen="true" width="'.$width.'" height="'.$height.'"></embed></object>';
	}
	
	function rt_embedVideo($vCode)
	{
	 	$params = $this->params;

		$width = $params->get('width', 425);
		$height = $params->get('height', 344);
	
		return '<object width="'.$width.'" height="'.$height.'"><param name="movie" value="http://video.rutube.ru/'.$vCode.'"><param name="wmode" value="window"><param name="allowFullScreen" value="true"><embed src="http://video.rutube.ru/'.$vCode.'" type="application/x-shockwave-flash" wmode="window" allowfullscreen="true" width="'.$width.'" height="'.$height.'"></object>';
	}
	
	function vk_embedVideo($vCode)
	{
	 	$params = $this->params;

		$width = $params->get('width', 425);
		$height = $params->get('height', 344);
	
		return '<iframe src="http://vk.com/video_ext.php?'.$vCode.'" width="'.$width.'" height="'.$height.'" frameborder="0"></iframe></embed></object>';
	}
	
	function vm_embedVideo($vCode)
	{
	 	$params = $this->params;

		$width = $params->get('width', 425);
		$height = $params->get('height', 344);
	
		return '<object width="'.$width.'" height="'.$height.'"><iframe src="//player.vimeo.com/video/'.$vCode.'?badge=0" width="'.$width.'" height="'.$height.'" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></object>';
	}
}
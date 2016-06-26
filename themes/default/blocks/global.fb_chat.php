<?php

/**
 * @Project NUKEVIET 4.x
 * @Author webvang (thanhhoang@vinades.vn)
 * @Copyright (C) 2014 VINADES ., JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Jun 26, 2016 11:34:27 AM
 */

if( ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );

if( ! nv_function_exists( 'nv_fb_chat' ) )
{
	function nv_fb_chat_config( $module, $data_block, $lang_block )
	{
		global $lang_global, $selectthemes;

		// Find language file
		if( file_exists( NV_ROOTDIR . '/themes/' . $selectthemes . '/language/block.global.fb_chat.php' ) )
		{
			include NV_ROOTDIR . '/themes/' . $selectthemes . '/language/block.global.fb_chat.php';
		}

		$html = '<tr>';
		$html .= '<td>' . $lang_block['fb_title'] . '</td>';
		$html .= '<td><input type="text" class="form-control" name="config_fb_title" value="' . $data_block['fb_title'] . '"></td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td>' . $lang_block['fb_link'] . '</td>';
		$html .= '<td><input type="text" class="form-control" name="config_fb_link" value="' . $data_block['fb_link'] . '"></td>';
		$html .= '</tr>';

		return $html;
	}

	function nv_fb_chat_submit()
	{
		global $nv_Request;

		$return = array();
		$return['error'] = array();
		$return['config']['fb_title'] = $nv_Request->get_title( 'config_fb_title', 'post' );
		$return['config']['fb_link'] = $nv_Request->get_title( 'config_fb_link', 'post' );

		return $return;
	}

	/**
	 * nv_menu_theme_default_footer()
	 *
	 * @param mixed $block_config
	 * @return
	 */
	function nv_fb_chat( $block_config )
	{
		global $global_config, $lang_global;

		if( file_exists( NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/blocks/global.fb_chat.tpl' ) )
		{
			$block_theme = $global_config['module_theme'];
		}
		elseif( file_exists( NV_ROOTDIR . '/themes/' . $global_config['site_theme'] . '/blocks/global.fb_chat.tpl' ) )
		{
			$block_theme = $global_config['site_theme'];
		}
		else
		{
			$block_theme = 'default';
		}

		$xtpl = new XTemplate( 'global.fb_chat.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/blocks' );
		$xtpl->assign( 'LANG', $lang_global );
		$xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
		$xtpl->assign( 'FB_TITLE', $block_config['fb_title'] );
		$xtpl->assign( 'FB_LINK', $block_config['fb_link'] );
		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
	}
}

if( defined( 'NV_SYSTEM' ) )
{
	$content = nv_fb_chat( $block_config );
}

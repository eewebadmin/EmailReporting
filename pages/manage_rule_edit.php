<?php
auth_reauthenticate( );
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );

require_once( plugin_config_get( 'path_erp', NULL, TRUE ) . 'core/config_api.php' );

$f_rule_action = gpc_get_string( 'rule_action' );
$f_select_rule = gpc_get_int( 'select_rule' );

$t_rules = plugin_config_get( 'rules' );

if ( $f_rule_action === 'add' || $f_rule_action === 'copy' || ( ( $f_rule_action === 'edit' || $f_rule_action === 'test' ) && $f_select_rule >= 0 ) )
{
	$t_rule = array(
		'enabled'				=> gpc_get_bool( 'enabled' ),
		'description'			=> gpc_get_string( 'description' ),
	);
}

if ( $f_rule_action === 'add' || $f_rule_action === 'copy' )
{
	$t_rules[] = $t_rule;
}
elseif ( $f_rule_action === 'edit' && $f_select_rule >= 0 )
{
	$t_rules[ $f_select_rule ] = $t_rule;
}
elseif ( $f_rule_action === 'delete' && $f_select_rule >= 0 )
{
	unset( $t_rules[ $f_select_rule ] );
}
elseif ( $f_rule_action === 'test' && $f_select_rule >= 0 )
{
	# Verify rule
/*	$t_no_redirect = TRUE;

	html_page_top( plugin_lang_get( 'plugin_title' ) );
?>
<br /><div class="center">
<?php
	echo plugin_lang_get( 'test_failure' ) . '<br /><br />';
	echo plugin_lang_get( 'description' ) . ': ' . $t_rule[ 'description' ] . '<br />';

	print_bracket_link( plugin_page( 'manage_rules', TRUE ), lang_get( 'proceed' ) );
?>
</div>
<?php
	html_page_bottom( __FILE__ );*/
}

if( plugin_config_get( 'rules' ) != $t_rules && ( $f_rule_action === 'add' || $f_rule_action === 'copy' || ( ( $f_rule_action === 'edit' || $f_rule_action === 'delete' ) && $f_select_rule >= 0 ) ) )
{
	plugin_config_set( 'rules', $t_rules );
}

if ( !isset( $t_no_redirect ) )
{
	print_successful_redirect( plugin_page( 'manage_rule', TRUE ) );
}
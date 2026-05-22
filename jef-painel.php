<?php
/*
 * Plugin Name: Painel Jeferson
 * Plugin URI: https://jefersonespindola.com/
 * Description: Painel personalizado Jeferson.
 * Author: Jeferson Espindola
 * Author URI: https://jefersonespindola.com/
 * Version: 1.0.9
 * Text Domain: jef-painel
 */


/**
 * Remover texto do rodapé
 * Obrigado por criar com ....
 */
function jef_painel_remove_footer_admin ()
{
    echo '';
}
add_filter('admin_footer_text', 'jef_painel_remove_footer_admin');

/**
 * Remover versão do rodapé
 */
function jef_painel_remove_footer_version() {
  return '';
}
add_filter('update_footer', 'jef_painel_remove_footer_version', 9999);

/**
 * Remover barra Admin fora da admin
 */
show_admin_bar(false);

/**
 * Remove o item opções de tela do topo
 */
function jef_painel_remove_screen_options() {
    return false;
}
add_filter('screen_options_show_screen', 'jef_painel_remove_screen_options');

/**
 * Remove o item ajuda do topo
 */
function jef_painel_remove_help_tabs() {
    $screen = get_current_screen();
    $screen->remove_help_tabs();
}
add_action('admin_head', 'jef_painel_remove_help_tabs');

/**
 * Carregar Css para admin e login
 */
function jef_painel_style() {
    $ver = filemtime(plugin_dir_path(__FILE__) . 'jef-painel-style.css');
    wp_enqueue_style('jef-painel-style', plugins_url('jef-painel-style.css', __FILE__), array(), $ver);
}
function jef_painel_style_login() {
    $ver = filemtime(plugin_dir_path(__FILE__) . 'jef-painel-style-login.css');
    wp_enqueue_style('jef-painel-style-login', plugins_url('jef-painel-style-login.css', __FILE__), array(), $ver);
}
add_action('admin_enqueue_scripts', 'jef_painel_style');
add_action('login_enqueue_scripts', 'jef_painel_style_login');




/**
 * Adiciona um novo conjunto de cores na adm chamado Jeferson
 */
function jef_painel_additional_admin_color_schemes() {
    $ver = filemtime(plugin_dir_path(__FILE__) . 'jef-painel-colors.css');
    wp_admin_css_color(
        'jef-painel',
        'Painel Jeferson',
        plugins_url( "jef-painel-colors.css", __FILE__) . '?ver=' . $ver
    );
}
add_action('admin_init', 'jef_painel_additional_admin_color_schemes');

/**
 * Marca o novo conjunto de cores como padrão
 */
add_filter('get_user_option_admin_color', 'jef_painel_change_admin_color');
function jef_painel_change_admin_color($result) {
    return 'jef-painel';
}

/**
 * Remove as opções de cores na Adm
 */
if(is_admin()){
  remove_action("admin_color_scheme_picker", "admin_color_scheme_picker");
}

/**
 * Adiciona itens ao menu lateral
 */
add_action( 'admin_menu', 'jef_painel_adjust_menu' );
function jef_painel_adjust_menu(){
  global $menu, $submenu;
  $current_user = wp_get_current_user();
  // $menu[1] = array( get_bloginfo( 'name' ), 'read', 'home_url()', '', 'menu-top', 'menu-ver-site', 'dashicons-admin-home' );
  // $menu['0.1'] = array( $current_user->display_name, 'read', 'profile.php', '', 'menu-top', 'menu-user', get_avatar_url($current_user->id) );
  $menu['0.1'] = array( " ", 'read', 'admin.php?page=jef_painel_dashboard', '', 'menu-top', 'menu-jef-painel-logo', plugins_url('logo-interna.svg', __FILE__));
  $menu[9999999] = array( __( 'Sair', 'jef-painel' ), 'read', wp_logout_url(), '', 'menu-top menu-logout', 'menu-logout', 'dashicons-migrate' );
}

/**
 * Novo dashboard
 */
add_action( 'admin_menu', 'jef_painel_dashboard' );
function jef_painel_dashboard(){
    add_menu_page('jef_painel_dashboard', __( 'Início', 'jef-painel' ), 'read', 'jef_painel_dashboard', 'jef_painel_include_dashboard');
    remove_menu_page('jef_painel_dashboard');
    global $parent_file, $submenu_file;
    $parent_file = 'index.php';
    // $submenu_file = 'index.php';
}
function jef_painel_include_dashboard() {
    include('jef-painel-dashboard.php');
}

add_action('admin_init', 'jef_painel_redirect_dashboard');
function jef_painel_redirect_dashboard() {
    global $pagenow;
    if($pagenow == 'index.php'){
        wp_redirect(admin_url('/admin.php?page=jef_painel_dashboard'), 301);
        exit;
    }
}

/**
 * Fix admin page title
 */
add_filter('admin_title', 'jef_painel_dashboard_admin_title', 10, 2);
function jef_painel_dashboard_admin_title($admin_title, $title)
{
    global $pagenow;
    if( $pagenow == 'admin.php' && $_GET['page'] == 'jef_painel_dashboard') {
        $admin_title = __( 'Painel', 'jef-painel' ) . ' ' . $admin_title;
    }
    return $admin_title;
}


/**
 * Muda a url do logo do login para jef-painel
 */

function jef_painel_login_url() {  return home_url(); }
add_filter( 'login_headerurl', 'jef_painel_login_url' );




add_action('in_admin_header', function () {
  if ($_GET['page'] != 'jef_painel_dashboard') return;
  remove_all_actions('admin_notices');
  remove_all_actions('all_admin_notices');
  // add_action('admin_notices', function () {
  //   echo 'My notice';
  // });
}, 1000);


add_action('admin_footer', 'jef_painel_footer');



function jef_painel_footer() {
    echo '<a href="#" id="newtogglemenu"><div class="hamburguer"></div></a><script>jQuery("#newtogglemenu").click(function(){jQuery("#wp-admin-bar-menu-toggle").trigger("click")});</script>';
}


/**
 * Remove notices
 */

add_action('admin_head', 'admin_only_warnings');

function admin_only_warnings() {
if(is_admin() && !current_user_can('administrator') ) {
  echo '<style type="text/css">

    .update-nag, .warning, .error, .updated {display:none!important;}
  </style>';
}
}

/**
 * Forçar a limpeza de cache do arquivo jef-painel-colors.css injetando a data de modificação
 */
add_filter('style_loader_src', 'jef_painel_colors_cache_bust', 9999, 2);
function jef_painel_colors_cache_bust($src, $handle) {
    if (strpos($src, 'jef-painel-colors.css') !== false) {
        $ver = filemtime(plugin_dir_path(__FILE__) . 'jef-painel-colors.css');
        $src = remove_query_arg('ver', $src);
        $src = add_query_arg('ver', $ver, $src);
    }
    return $src;
}

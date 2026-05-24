<?php
/*
 * Plugin Name: Painel Jeferson
 * Plugin URI: https://jefersonespindola.com/
 * Description: Painel personalizado Jeferson.
 * Author: Jeferson Espindola
 * Author URI: https://jefersonespindola.com/
 * Version: 1.1.3
 * Text Domain: jef-painel
 * Requires at least: 5.8
 * Requires PHP: 7.4
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Remover texto do rodapé
 * Obrigado por criar com ....
 */
function pj_remove_footer_admin() {
    echo '';
}
add_filter( 'admin_footer_text', 'pj_remove_footer_admin' );

/**
 * Remover versão do rodapé
 */
function pj_remove_footer_version() {
    return '';
}
add_filter( 'update_footer', 'pj_remove_footer_version', 9999 );

/**
 * Remover barra Admin fora da admin
 */
show_admin_bar( false );

/**
 * Remove o item opções de tela do topo
 */
function pj_remove_screen_options() {
    return false;
}
add_filter( 'screen_options_show_screen', 'pj_remove_screen_options' );

/**
 * Remove o item ajuda do topo
 */
function pj_remove_help_tabs() {
    $screen = get_current_screen();
    if ( $screen ) {
        $screen->remove_help_tabs();
    }
}
add_action( 'admin_head', 'pj_remove_help_tabs' );

/**
 * Carregar Css para admin e login
 */
function pj_style() {
    $ver = filemtime( plugin_dir_path( __FILE__ ) . 'assets/css/jef-painel-style.css' );
    wp_enqueue_style( 'jef-painel-style', plugins_url( 'assets/css/jef-painel-style.css', __FILE__ ), array(), $ver );
}
function pj_style_login() {
    $ver = filemtime( plugin_dir_path( __FILE__ ) . 'assets/css/jef-painel-style-login.css' );
    wp_enqueue_style( 'jef-painel-style-login', plugins_url( 'assets/css/jef-painel-style-login.css', __FILE__ ), array(), $ver );
}
add_action( 'admin_enqueue_scripts', 'pj_style' );
add_action( 'login_enqueue_scripts', 'pj_style_login' );

/**
 * Adiciona um novo conjunto de cores na adm chamado Jeferson
 */
function pj_additional_admin_color_schemes() {
    $ver = filemtime( plugin_dir_path( __FILE__ ) . 'assets/css/jef-painel-colors.css' );
    wp_admin_css_color(
        'jef-painel',
        'Painel Jeferson',
        plugins_url( 'assets/css/jef-painel-colors.css', __FILE__ ) . '?ver=' . $ver
    );
}
add_action( 'admin_init', 'pj_additional_admin_color_schemes' );

/**
 * Marca o novo conjunto de cores como padrão
 */
add_filter( 'get_user_option_admin_color', 'pj_change_admin_color' );
function pj_change_admin_color( $result ) {
    return 'jef-painel';
}

/**
 * Remove as opções de cores na Adm
 */
if ( is_admin() ) {
    remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
}

/**
 * Adiciona itens ao menu lateral
 */
add_action( 'admin_menu', 'pj_adjust_menu' );
function pj_adjust_menu() {
    global $menu, $submenu;
    $current_user = wp_get_current_user();
    $logo_url     = esc_url( plugins_url( 'assets/images/logo-interna.svg', __FILE__ ) );
    $menu['0.1']  = array( ' ', 'read', 'admin.php?page=jef_painel_dashboard', '', 'menu-top', 'menu-jef-painel-logo', $logo_url );
    $menu[9999999] = array( __( 'Sair', 'jef-painel' ), 'read', wp_logout_url(), '', 'menu-top menu-logout', 'menu-logout', 'dashicons-migrate' );
}

/**
 * Novo dashboard
 */
add_action( 'admin_menu', 'pj_dashboard' );
function pj_dashboard() {
    add_menu_page( 'jef_painel_dashboard', __( 'Início', 'jef-painel' ), 'read', 'jef_painel_dashboard', 'pj_include_dashboard' );
    remove_menu_page( 'jef_painel_dashboard' );
    global $parent_file, $submenu_file;
    $parent_file = 'index.php';
}

function pj_include_dashboard() {
    include plugin_dir_path( __FILE__ ) . 'includes/jef-painel-dashboard.php';
}

add_action( 'admin_init', 'pj_redirect_dashboard' );
function pj_redirect_dashboard() {
    global $pagenow;
    if ( $pagenow == 'index.php' ) {
        wp_safe_redirect( admin_url( '/admin.php?page=jef_painel_dashboard' ), 301 );
        exit;
    }
}

/**
 * Fix admin page title
 */
add_filter( 'admin_title', 'pj_dashboard_admin_title', 10, 2 );
function pj_dashboard_admin_title( $admin_title, $title ) {
    global $pagenow;
    $page = isset( $_GET['page'] ) ? sanitize_text_field( wp_unslash( $_GET['page'] ) ) : '';
    if ( $pagenow == 'admin.php' && $page == 'jef_painel_dashboard' ) {
        $admin_title = __( 'Painel', 'jef-painel' ) . ' ' . $admin_title;
    }
    return $admin_title;
}

/**
 * Muda a url do logo do login para jef-painel
 */
function pj_login_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'pj_login_url' );

add_action( 'in_admin_header', function () {
    $page = isset( $_GET['page'] ) ? sanitize_text_field( wp_unslash( $_GET['page'] ) ) : '';
    if ( $page != 'jef_painel_dashboard' ) {
        return;
    }
    remove_all_actions( 'admin_notices' );
    remove_all_actions( 'all_admin_notices' );
}, 1000 );

add_action( 'admin_footer', 'pj_footer' );
function pj_footer() {
    echo '<a href="#" id="newtogglemenu"><div class="hamburguer"></div></a><script>jQuery("#newtogglemenu").click(function(){jQuery("#wp-admin-bar-menu-toggle").trigger("click")});</script>';
}

/**
 * Remove notices
 */
add_action( 'admin_head', 'pj_admin_only_warnings' );
function pj_admin_only_warnings() {
    if ( is_admin() && ! current_user_can( 'administrator' ) ) {
        echo '<style type="text/css">
            .update-nag, .warning, .error, .updated {display:none!important;}
        </style>';
    }
}

/**
 * Forçar a limpeza de cache do arquivo jef-painel-colors.css injetando a data de modificação
 */
add_filter( 'style_loader_src', 'pj_colors_cache_bust', 9999, 2 );
function pj_colors_cache_bust( $src, $handle ) {
    if ( strpos( $src, 'jef-painel-colors.css' ) !== false ) {
        $ver = filemtime( plugin_dir_path( __FILE__ ) . 'assets/css/jef-painel-colors.css' );
        $src = remove_query_arg( 'ver', $src );
        $src = add_query_arg( 'ver', $ver, $src );
    }
    return $src;
}

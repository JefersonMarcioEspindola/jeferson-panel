<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
?>
<style>
.jef-painel-dashboard-body {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 70vh;
    flex-direction: column;
    background: #fff;
    padding: 10px;
}
.jef-painel-dashboard-body .dashicons {
    font-size: 40px;
    color: #be2c63;
    width: 45px;
    height: 45px;
}
.text-center {
    text-align: center;
}
.jef-painel-dashboard-body .tutoriais {
    display: flex;
    max-width: 1000px;
        padding: 22px;
    padding-top: 0px;
    padding-bottom: 0px;
    flex-wrap: wrap;
}
.jef-painel-dashboard-body .col-3 {
    padding: 1%;
    flex-basis: 31%;
}
@media (max-width: 783px) {
    .jef-painel-dashboard-body .tutoriais {
        display: block;
    }
    .jef-painel-dashboard-body .col-3{
        width: 75%;
        margin: auto;
        margin-bottom: 12px;
    }
}
.jef-painel-dashboard-body .col-3:last-child {
    padding-right: 0;
}
.jef-painel-dashboard-body .tutoriais img {
    width: 100%
}
.user-info {
    border-bottom: 2px solid #ddd;
    padding-bottom: 5px;
}

@media (max-width: 783px) {
    .user-info {
        width: 100%;
        text-align: right;
        border-bottom: 0px;
        padding-top: 10px;
        padding-right: 20px;
        position: absolute;
        box-sizing: border-box;
        top: -10px;
    }
    .no-mobile {
        display: none;
    }
}

.user-info a{
    text-decoration: none;
}
hr{
    border: 0px;
    border-top: 2px solid #be2c63;
    width: 100px;
    margin: 30px 0px;
}
#wpbody-content {
    padding-bottom: 0px;
}

h1, h2, h3, h4, h5 {
    color: #21404e
}
h1 {
    text-transform: uppercase;
    font-weight: bold!important;
    letter-spacing: 1px;
}
.wrap {
    margin-top: 20px;
}
h2.subtitle {
        font-size: 16px;
    font-weight: normal;
    text-transform: uppercase;
    color: #464646;
    margin-top: 0px;
    letter-spacing: 1px;
    margin-bottom: 30px;
}
.jef-painel-right{
    float: right;
}
h4 {
    margin-bottom: 0px;
}
h2 {
        font-size: 1.6rem;
}

.texto1 {
    color: #282828;
    font-size: 25px;
    font-weight: 800;
    font-family: arial;
    margin-bottom: 0px;
}

.texto2 {
    color: #5e5e5e;
    font-size: 16px;
    font-weight: 500;
    font-family: arial;
}
</style>
<?php
$current_user = wp_get_current_user();
include('variaveis.php');
?>

<div class="wrap user-info">
    <a href="<?=home_url()?>" target="_blank"><?php esc_html_e( 'Visit Site', 'jef-painel' ); ?></a> &nbsp;

    <div class="jef-painel-right">
        <span class="no-mobile">

        <?php echo date("d/m/Y @ H:i") ?> |
        </span>
        <span class="no-mobile">
        <?php echo $current_user->user_email ?> </span> |
        <a href="<?php echo wp_logout_url(); ?>"><?php esc_html_e( 'Log Out', 'jef-painel' ); ?></a>

    </div>

</div>
<div class="wrap jef-painel-dashboard-body text-center">
    <img src="<?php echo esc_url( plugins_url( 'adminimg.svg', __FILE__ ) ); ?>" alt="Jeferson Panel illustration">
    <p class="texto1"><?php esc_html_e( 'Welcome to Jeferson Panel', 'jef-painel' ); ?></p>

    <p class="texto2">
        <?php esc_html_e( 'Access all usage tutorials sent to your email before starting to manage your site\'s content.', 'jef-painel' ); ?>
    </p>
  
    <?php echo $emails ?>


    


</div>

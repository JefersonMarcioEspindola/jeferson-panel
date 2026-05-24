# Feature: Painel Jeferson (Custom Admin Dashboard & Styles)

## 1. Propósito (Purpose)
Personalizar a interface administrativa do WordPress para usuários, ocultando notices genéricos e fornecendo uma tela inicial (dashboard) customizada com tutoriais, além de customizações de login e identidade visual.

## 2. Arquitetura (Architecture)
O plugin intercepta diversos hooks do WordPress para customizar o painel:
- **`admin_enqueue_scripts` & `login_enqueue_scripts`**: Registram e enfileiram estilos sob as funções `pj_style()` e `pj_style_login()`.
- **`admin_init` (Color Scheme)**: Registra o esquema de cores personalizado sob `pj_additional_admin_color_schemes()` e o define como padrão no filtro `get_user_option_admin_color`.
- **`admin_menu`**:
  - `pj_adjust_menu()` injeta o logotipo e formata o item de menu "Sair".
  - `pj_dashboard()` adiciona a página de dashboard customizada sob o slug `jef_painel_dashboard` e redireciona a home padrão do admin (`index.php`) para ela.
- **`admin_title`**: `pj_dashboard_admin_title()` altera o título da página inicial no navegador para "Painel".
- **`in_admin_header`**: Remove os notices de admin padrão do WordPress (`admin_notices`, `all_admin_notices`) quando o usuário está visualizando a página do dashboard customizado.
- **`admin_head`**: `pj_admin_only_warnings()` oculta classes CSS de avisos/erros comuns para usuários não-administradores.
- **`style_loader_src`**: `pj_colors_cache_bust()` adiciona query argument `ver` com o `filemtime` do arquivo de estilo de cores para evitar cache agressivo de navegadores.

## 3. Localização (Files Involved)
- **Arquivo Principal**: [jef-painel.php](file:///Users/jefersonespindola/Desktop/Jeferson%20Panel/jeferson-panel/jef-painel.php)
- **Dashboard View & Logic**: [includes/jef-painel-dashboard.php](file:///Users/jefersonespindola/Desktop/Jeferson%20Panel/jeferson-panel/includes/jef-painel-dashboard.php)
- **Assets de Estilo**: 
  - [assets/css/jef-painel-style.css](file:///Users/jefersonespindola/Desktop/Jeferson%20Panel/jeferson-panel/assets/css/jef-painel-style.css) (Estilo geral admin)
  - [assets/css/jef-painel-style-login.css](file:///Users/jefersonespindola/Desktop/Jeferson%20Panel/jeferson-panel/assets/css/jef-painel-style-login.css) (Estilo tela login)
  - [assets/css/jef-painel-colors.css](file:///Users/jefersonespindola/Desktop/Jeferson%20Panel/jeferson-panel/assets/css/jef-painel-colors.css) (Paleta de cores customizada)
- **Assets Gráficos**:
  - [assets/images/adminimg.svg](file:///Users/jefersonespindola/Desktop/Jeferson%20Panel/jeferson-panel/assets/images/adminimg.svg)
  - [assets/images/logo-interna.svg](file:///Users/jefersonespindola/Desktop/Jeferson%20Panel/jeferson-panel/assets/images/logo-interna.svg)
  - [assets/images/logo-login.svg](file:///Users/jefersonespindola/Desktop/Jeferson%20Panel/jeferson-panel/assets/images/logo-login.svg)

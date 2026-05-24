[🇺🇸 Read in English](#english) | [🇧🇷 Leia em Português](#portugues)

<a name="english"></a>
# Painel Jeferson (Jeferson Panel)

A WordPress plugin that personalizes the WordPress admin area with a clean and custom dashboard, dedicated stylesheets, custom admin color schemes, and a refined login page.

## Features
- **Customized Login Screen**: Injects a custom stylesheet (`jef-painel-style-login.css`) and a custom logo (`logo-login.svg`) into the login page.
- **Custom Admin Color Scheme**: Introduces the "Painel Jeferson" color palette and sets it as the default scheme.
- **Clean Admin Layout**: Hides unnecessary default admin notices, update alerts, screen options, and help tabs.
- **Dedicated Dashboard View**: Redirects the standard WordPress dashboard to a simplified custom dashboard layout containing tutorials.
- **Polished Sidebar**: Optimizes sidebar navigation width, logo, and adds a dedicated logout button.

## Directory Structure
- `assets/css/`: Houses custom stylesheets for the main admin area, custom color scheme, and the login page.
- `assets/images/`: Stores image and SVG assets such as the login and internal logos.
- `includes/`: Contains the logic and view for the custom admin dashboard page.
- `docs/`: Technical documents and guidelines for AI and context continuity.

## Security Controls
- **Direct Access Protection**: All PHP files start with standard checks to prevent direct execution (`defined('ABSPATH') || exit;`).
- **Input Sanitization**: Query variables are sanitized using `sanitize_text_field` and `wp_unslash`.
- **Late Escaping**: Values printed inside HTML wrappers are escaped using appropriate functions (`esc_url`, `esc_html`, and `wp_kses_post`).

---

<a name="portugues"></a>
# Painel Jeferson

Um plugin para WordPress que personaliza a área administrativa com um painel simplificado e customizado, folhas de estilo dedicadas, esquema de cores administrativo próprio e tela de login refinada.

## Funcionalidades
- **Tela de Login Personalizada**: Injeta folha de estilo customizada (`jef-painel-style-login.css`) e logotipo personalizado (`logo-login.svg`) na tela de login.
- **Esquema de Cores Customizado**: Adiciona a paleta "Painel Jeferson" para a administração e define-a como o esquema padrão.
- **Layout de Admin Limpo**: Oculta avisos padrão de atualização, opções de tela e guias de ajuda para usuários não administradores.
- **Página de Dashboard Exclusiva**: Redireciona o painel padrão do WordPress para uma tela customizada simplificada com tutoriais de uso.
- **Menu Lateral Polido**: Ajusta a largura da barra de navegação, exibe o logo e adiciona um atalho proeminente para deslogar.

## Estrutura de Pastas
- `assets/css/`: Armazena as folhas de estilo da administração, login e esquema de cores.
- `assets/images/`: Armazena as imagens e arquivos SVG utilizados no painel.
- `includes/`: Contém a lógica e a view da página de dashboard administrativo.
- `docs/`: Pasta dedicada a documentos técnicos de contexto para IAs.

## Controles de Segurança
- **Proteção contra Acesso Direto**: Todos os arquivos PHP incluem a checagem padrão para impedir execução direta (`defined('ABSPATH') || exit;`).
- **Sanitização de Inputs**: Parâmetros de requisições globais são tratados com `sanitize_text_field` e `wp_unslash`.
- **Escape Tardio**: Toda renderização em HTML utiliza funções de escape recomendadas (`esc_url`, `esc_html` e `wp_kses_post`).

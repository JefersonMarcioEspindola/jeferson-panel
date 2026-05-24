# Diretrizes Gerais de Desenvolvimento - WordPress Plugins (Jeferson)

Este documento compila a versão integral e fiel das 4 skills globais criadas para guiar o desenvolvimento dos plugins WordPress (*JESync Manager for GitHub*, *Full Translate* e *Painel Jeferson*).

---

## 1. Skill: wp-plugin-structure (Estrutura e Arquivos Base)

### Padrão de Arquitetura e Estrutura de Pastas para Plugins WordPress
Sempre que iniciar a criação, auditoria ou reestruturação de um plugin WordPress, aplique rigorosamente esta arquitetura de duas camadas (Raiz do Repositório vs. Pasta do Plugin).

#### Camada 1: Raiz do Repositório Git (Organização e Contexto)
O diretório raiz do repositório Git serve para fins de controle de versão, documentação de IA e licenças. Ele NÃO deve conter os arquivos lógicos do plugin soltos na raiz. A raiz deve conter:
- `[plugin-slug]/` (Diretório exclusivo do plugin. Todo o código PHP, JS, CSS do plugin deve ficar aqui dentro).
- `docs/` (Pasta contendo arquivos markdown para contexto de IA, incluindo obrigatoriamente o arquivo `claude.md` fornecido pelo usuário).
- `README.md` (Arquivo explicativo bilíngue inglês/português voltado para exibição no GitHub).
- `LICENSE` (Licença oficial GPLv2 ou superior para conformidade com o WordPress.org).
- `.gitignore` (Regras de ignore do Git).

#### Camada 2: Diretório do Plugin (`/[plugin-slug]/`)
Esta pasta contém apenas o que será de fato empacotado ou copiado para a pasta `wp-content/plugins/` do WordPress. Nada além do estritamente necessário para o funcionamento do plugin deve existir aqui.
- `[plugin-slug].php` (Arquivo de bootstrap principal, com o mesmo nome da pasta).
- `readme.txt` (Arquivo de metadados oficial exigido pelo diretório do WordPress.org).
- `includes/` (Organização lógica PHP: classes, controllers, helpers).
- `assets/` (Recursos estáticos divididos em `css/` e `js/`).
- `languages/` (Traduções `.pot`, `.po`, `.mo`).

#### Diretrizes de Nomenclatura e Evitar Marcas Registradas (Trademarks)
- O nome de exibição e o slug (`[plugin-slug]`) não devem iniciar com marcas registradas de terceiros (como "GitHub", "WooCommerce", etc.) para evitar falsa impressão de afiliação oficial.
- Use o padrão: `[Nome Único] para [Marca]` (ex: `JESync Manager for GitHub` com slug `jesync-manager-for-github`).

#### Padrão do README.md Bilíngue (Raiz do Git)
- Estruturado com o idioma **Inglês no topo** e **Português na parte inferior**.
- Utilize um sistema de links âncora no topo:
  ```markdown
  [🇺🇸 Read in English](#english) | [🇧🇷 Leia em Português](#portugues)
  ```
- O cabeçalho deve declarar corretamente os colaboradores ("Contributors") com o usuário oficial do WordPress.org.

#### Documentação de Serviços Externos (Obrigatório)
- Caso o plugin realize requisições externas ou downloads (ex: API do GitHub), descreva isso no `README.md` e `readme.txt` sob a seção `== External Services ==` / `== Serviços externos ==` detalhando:
  1. Propósito da conexão.
  2. Dados enviados e quando.
  3. Links para Termos de Serviço e Política de Privacidade do terceiro.

#### Configuração do .gitignore (Raiz do Git)
- Ignorar `node_modules/`, `vendor/`.
- Ignorar artefatos de IDEs (`.vscode/`, `.idea/`).
- Ignorar arquivos `.DS_Store` e temporários.
- **NÃO ignore a pasta `docs/`**.

---

## 2. Skill: wp-plugin-checker-standards (Boas Práticas e Segurança)

### Regras de Código WordPress (Plugin Checker Compliance)
Ao escrever qualquer trecho de código, siga estas regras restritas. Os plugins (*GitHub Sync Manager*, *Full Translate*, *Painel Jeferson*) devem ser blindados e aprováveis em qualquer revisão do WordPress.org.

#### Regra de Prefixos (WP Standards)
- **Mínimo de 4 Caracteres**: Todo prefixo de função, classe, constante, variável global ou option deve ter pelo menos 4 caracteres exclusivos (ex: `codesync_`, `fulltrans_`, `painelje_`). **Evite prefixos de 2 ou 3 letras** (como `gsm_`, `ft_`, `pj_`), pois serão rejeitados pelo Plugin Checker.
- **Preservação de Código Ativo**: Se o plugin analisado já possui um prefixo exclusivo estabelecido (como `codesync_`), **NÃO faça a refatoração dele**. Alterar prefixos de plugins publicados quebra a compatibilidade com opções e metadados salvos no banco de dados dos usuários. Só aplique novos prefixos em código novo ou se for um rebranding total solicitado explicitamente.

#### Segurança Absoluta (Sanitize, Escape & Validate)
- **Sanitização**: Jamais confie no input do usuário. Use `sanitize_text_field()`, `absint()`, `sanitize_textarea_field()` sempre ao salvar ou receber variáveis globais (`$_POST`, `$_GET`).
- **Escape**: Ao renderizar outputs no HTML, use SEMPRE as funções de escape tardio: `esc_html()`, `esc_attr()`, `esc_url()`, ou `wp_kses()`.
- **Validação de Permissões**: Requisições AJAX ou manipulações de formulário admin DEVEM checar privilégios usando `current_user_can('manage_options')` e `check_ajax_referer()` (Nonces).

#### Integração com Banco de Dados
- Não crie tabelas customizadas a menos que estritamente necessário. Prefira as tabelas `wp_options` ou Custom Post Types.
- Ao usar opções, evite inflar o `autoload` sem necessidade (passe `false` para opções enormes).
- Interações de banco: Use exclusivamente o objeto `$wpdb->prepare()`.

#### Otimização no Frontend
- Enfileire scripts (Enqueue) de forma condicional, injetando CSS/JS apenas nas páginas em que o plugin atua.

---

## 3. Skill: wp-plugin-ai-context (Documentação de IA)

### Documentação Contínua para Contexto de IAs (docs/)
Nosso fluxo de desenvolvimento utiliza IAs combinadas (como Antigravity e Claude Code). Para garantir consistência entre as sessões e ferramentas, adotamos a pasta `docs/` como nosso cérebro persistente.

#### O Arquivo Fonte da Verdade (claude.md)
- O usuário colocará manualmente um arquivo chamado `docs/claude.md` na raiz da pasta de documentação.
- **Esse arquivo é a sua fonte primária de verdade**. A IA deve lê-lo assim que iniciar o trabalho no projeto para carregar regras específicas de negócios, preferências de design ou segredos de arquitetura do Jeferson.

#### A Pasta docs/ e Features Técnicas
- A pasta `docs/` deve ficar localizada na raiz do repositório Git.
- Sempre que uma funcionalidade principal do plugin for finalizada ou modificada, crie ou atualize um arquivo de documentação técnica conciso (ex: `docs/feature-nome-da-feature.md`).

#### Formato das Fichas de Feature
Mantenha os documentos extremamente objetivos e focados, contendo:
- **Propósito**: O problema que a feature resolve.
- **Arquitetura**: Quais ganchos (hooks) do WordPress ela utiliza e como se integra ao plugin.
- **Localização dos Arquivos**: Quais arquivos/classes contêm a lógica implementada.

Essa documentação deve ser rastreada pelo Git para garantir que qualquer nova sessão de IA entenda instantaneamente o estado atual do software.

---

## 4. Skill: wp-plugin-versioning (Versionamento e Releases)

### Padrão de Versionamento (Release Protocol)
Quando instruído a gerar uma nova versão ou preparar o sistema para um novo lançamento, aplique a seguinte lógica em cadeia:

#### Regras de Nomenclatura (Semantic Versioning)
- Utilize as diretrizes MAJOR.MINOR.PATCH (ex: `1.0.0` para `1.0.1`).

#### Atualização em Cascata (Update Chain)
Mude o número da versão nos seguintes arquivos:
- O arquivo principal do plugin (`Version: X.X.X` no comentário do cabeçalho PHP).
- O arquivo `README.md` principal.
- O arquivo `readme.txt` padrão para a galeria do WordPress (`Stable tag: X.X.X`).

#### Manutenção do Changelog
- Atualize a seção de `## Changelog` no `README.md`.
- Agrupe por: `Added` (Novidades), `Fixed` (Correções), e `Changed` (Alterações).

#### O Fluxo Simplificado de Releases
- Lembre-se: O *GitHub Sync Manager* cuida das atualizações automáticas via commit para a maioria dos plugins.
- Portanto, para a maioria dos projetos (como *Full Translate* e *Painel Jeferson*), o simples "bump version" nos arquivos acima e um **git commit** é o suficiente.
- Não gere zips de release a menos que estritamente solicitado.

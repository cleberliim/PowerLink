# Powerlink

PowerLink é um gerenciador de Power BI que permite administrar seus dashboards com facilidade, garantindo praticidade e insights valiosos sem complicações.

## Estrutura de Diretórios

```plaintext
/Powerlink
    /config
        conn.php           # Arquivo de conexão com o banco de dados
        functions.php      # Funções auxiliares utilizadas no projeto
        menus.php          # Gerenciamento de menus e permissões
    /includes
        header.php         # Cabeçalho comum em todas as páginas
        footer.php         # Rodapé comum em todas as páginas
    /pages
        dashboard.php      # Página principal (dashboard)
        profile.php        # Página de perfil do usuário
        [outros arquivos]  # Páginas relacionadas ao BI
    /assets
        /images
            integralogis.svg   # Logo da empresa
            user.png           # Imagem padrão de usuário
        /css
            custom.css         # Estilo personalizado
    createaccount.php       # Página de criação de contas
    login.php               # Página de login
    sair.php                # Script para logout
    admin.php               # Página de administração
```

## Instruções de Configuração

1. **Clone o Repositório:**

   ```bash
   git clone https://github.com/cleberliim/Powerlink.git
   ```

2. **Configurar o Banco de Dados:**

   - Certifique-se de criar o banco de dados conforme definido no arquivo `config/conn.php`.
   - Importe o arquivo SQL [Powerlink.sql](./Powerlink.sql) para configurar as tabelas iniciais.

3. **Ajustar Arquivo `conn.php`:**

   - Configure os detalhes de conexão com o banco de dados (host, usuário, senha, nome do banco).

4. **Executar o Projeto:**
   - Utilize um servidor local como [XAMPP](https://www.apachefriends.org/index.html) ou [WAMP](https://www.wampserver.com/) para rodar o projeto.

## Tecnologias Utilizadas

- **PHP**: Para o backend e lógica do projeto.
- **MySQL**: Banco de dados relacional.
- **HTML/CSS**: Para estruturação e estilo das páginas.
- **JavaScript**: Para interatividade no frontend.

## Funcionalidades

- **Login e Cadastro**: Controle de usuários com autenticação.
- **Dashboard**: Painel principal com relatórios BI.
- **Administração**: Gestão de usuários e relatórios.

## Contribuição

Sinta-se à vontade para contribuir com melhorias e novas funcionalidades. Crie um _pull request_ ou abra uma _issue_ para discutirmos as mudanças.

## Licença

Este projeto está licenciado sob os termos da MIT License.

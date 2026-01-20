✅ O que você deve fazer para apagar um projeto (repositório)
Passo a passo no GitHub

    Entre no repositório que você quer apagar
    (clique nele na lista de repositórios)

    Clique em Settings (menu do topo do repositório)

    Role a página até o final até a seção Danger Zone

    Clique em Delete this repository

    O GitHub vai pedir:

    O nome exato do repositório (para confirmar)

    Às vezes, senha ou 2FA

    Confirme → repositório apagado definitivamente

    ⚠️ Importante:
    Depois de apagar, não tem como recuperar (commits, issues, histórico, tudo some).

    🔄 Se você tiver vários projetos antigos

    Repita o processo um por um para cada repositório.

    O GitHub não tem botão “apagar tudo” de uma vez (por segurança).
-------------------------------------------------------------------------------------------------------------



1) Pré-requisitos (uma vez só)
1.1 Instalar o Git no Windows

Baixe e instale o Git for Windows.

Durante o instalador, deixe marcado para instalar o Git Credential Manager (normalmente já vem).

Reinicie o VS Code se ele estiver aberto.

1.2 Conferir se o Git está OK

Abra o Terminal no VS Code (Ctrl+`) e rode:

git --version


Se aparecer a versão, ok.

1.3 Configurar seu nome e email (uma vez)

No terminal:

git config --global user.name "Seu Nome"
git config --global user.email "seuemail@dominio.com"


Conferir:

git config --global --list

2) Conectar VS Code no GitHub (login)
    no terminal digite:
        code --list-extensions | findstr github
            vai aparecer algo assim:
                github.copilot
                github.copilot-chat
                github.vscode-pull-request-github

    se nao aparecer instale:
        code --install-extension GitHub.vscode-pull-request-github


3) Criar o repositório no GitHub (projeto cru)

    No GitHub (site), clique New repository
    Nome sugerido (exemplo): base-universal-cru (você decide)
    Marque Private ou Public
    Não marque “Add a README” (opcional; eu recomendo deixar sem para não conflitar)
    Clique Create repository
    Deixe essa tela aberta porque você vai copiar a URL do repo.

4) Subir o projeto local para o GitHub (passo a passo)
    Cenário A (recomendado): você já tem o projeto aberto no VS Code
    Abra a pasta do seu projeto cru no VS Code (File → Open Folder)
    Abra Source Control (Ctrl+Shift+G)
    Se aparecer “Initialize Repository” → clique.
    Isso cria o .git localmente.

4.1 Criar o primeiro commit
    No Source Control, clique em + para “Stage” (ou “Stage All Changes”)
    No campo de mensagem, digite algo como:
    chore: initial commit (projeto cru)
    Clique em Commit
    Se o VS Code pedir para “Enable Smart Commit” ou algo assim, pode aceitar.

4.2 Ligar o repositório local ao GitHub (remote)

    Agora você precisa adicionar o “remote origin”.
    No terminal do VS Code, rode:
    git branch -M main
    Agora adicione o remote (use a URL do seu repo):
    Se for HTTPS (mais simples):
    git remote add origin https://github.com/vagnerlemos/base-universal-cru
    Conferir:
    git remote -v

4.3 Fazer o push (enviar)
    git push -u origin main
    Na primeira vez, vai abrir login/autorizar. Conclua.
    Depois disso, os próximos push/commit ficam fáceis.

5) Fluxo diário (commit + push)

Alterou arquivos

Source Control → Stage changes

Escreve mensagem → Commit

Clica em Sync Changes (ou roda no terminal):

git push

6) Checklist para você não misturar “cru” com “filament/spatie”

Repo 1: projeto-cru (base, sem dependências pesadas)

Repo 2: projeto-filament-spatie (cópia do cru + evolução)

Quando for criar o segundo:

Faça uma cópia da pasta local

Abra a cópia no VS Code

git init (ou Initialize Repository)

Crie outro repo no GitHub

Repita os passos 4.1 a 4.3

7) Se der erro no push (o mais comum)
“remote origin already exists”
git remote set-url origin https://github.com/SEU_USUARIO/NOME_DO_REPO.git

“failed to push some refs”

Geralmente acontece quando o GitHub tem commit inicial (README) e seu local também.
Solução mais direta (se repo está vazio mesmo):

git push -u origin main --force


(Use só se você tem certeza que quer sobrescrever o remoto.)

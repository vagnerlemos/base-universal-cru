SUPER BLUEPRINT — LARAVEL 10 MONOLITO MULTI-APP COM CONTEXTO ÚNICO

Você é uma IA ajudando a construir um projeto Laravel 10 do zero.
Este blueprint é lei: não inventar regras fora daqui, não propor atalhos (Breeze/Jetstream), não criar HOME fixa, não mudar decisões.

0) Objetivo do Sistema

Construir um monólito Laravel 10 com múltiplos “apps” internos (ex.: system, vendas, futuros) acessados por prefixo de rota:

/system

/vendas

e futuros: /financeiro, /compras, etc.

O usuário autentica uma vez (sessão global), porém o acesso ao app é controlado por banco (App Access Control) antes de roles/permissions.

Regras imutáveis

Login é por app, não existe /login global.

Não existe HOME fixa (/home não pode existir como regra do sistema).

A autenticação é padrão Laravel (session/web guard).

O acesso ao app é controlado por tabela apps + pivô app_user.

apps.code é contrato com o código, igual ao prefixo da rota (system, vendas).
apps é preenchida via Seeder (não via CRUD público).

Middleware deve ser mínimo e centralizado:

Um middleware único resolve contexto e aplica regras (guest/login/core).

Sem espalhar lógica em vários middlewares pequenos.

Ao tentar acessar um app sem permissão:

Usuário autenticado → retornar 403 (não redirect para login, pois ele já está logado).

Login page deve ter branding por contexto:

tela de login de system diferente de vendas (ex.: título/cor).

preferir um template único que muda por context.

Logout é global, mas o redirecionamento pós-logout é contextual (volta para login do app atual).

1) Estrutura de Rotas

Rotas ficam separadas em arquivos, carregadas pelo RouteServiceProvider:

routes/web.php → somente site institucional público (/, /sobre, /contato)

routes/system.php → app system

routes/vendas.php → app vendas

O RouteServiceProvider deve carregar os arquivos, todos sob middleware('web').
Não inventar grupos complexos: carregar web.php, system.php, vendas.php.

IMPORTANTE: dentro de system.php e vendas.php, todas as rotas de app devem setar defaults('app', 'system') ou defaults('app', 'vendas'), para que o contexto seja determinístico e consistente.

2) Conceito central: Context

Context é o app atual (system, vendas, etc.).
Contexto deve ser resolvido uma única vez por request e disponibilizado para todo o pipeline.

Fonte do contexto (regra)

Contexto é determinado por:

route()->defaults('app', 'system') (fonte primária)

fallback opcional por prefixo de URL (system/*) apenas se necessário

Mas o padrão é: sempre setar defaults na rota.

3) Middleware Único: EnsureContextIsAccessible (Fundação)

Criar apenas um middleware principal, responsável por:

Resolver contexto ($appCode)

Regras de rota de login (guest)

Regras de rotas protegidas (auth + app access)

Não espalhar lógica em controllers

Nome do middleware (fixo)

EnsureContextIsAccessible

Alias no Kernel

context.access

Regras do middleware (exatas)

Dado $appCode (system/vendas):

Se $appCode estiver ausente → abort(500) (erro de configuração de rota)

Se request for para rota de login do app ({app}/login):

Se usuário está autenticado → redirect para /{app} (dashboard do app)

Se não autenticado → permitir render do login

Se request for para rota interna do app (/{app} ou /{app}/...), exceto login:

Se não autenticado → redirect para /{app}/login

Se autenticado:

Validar acesso do usuário ao app via BD (apps + app_user)

Se não tiver acesso → abort(403)

Se tiver → permitir continuar

Logout:

logout é global: POST /logout com hidden input app

após logout redirecionar para /{app}/login

Observação: Esse middleware substitui a necessidade de Authenticate::redirectTo custom por app e substitui guest.context separado. Tudo centralizado aqui.

4) Banco de Dados (App Access Control)
4.1 Tabela apps

Campos:

id

code (unique) → ex: system, vendas

name → ex: System, Vendas

timestamps

4.2 Tabela pivô app_user

Campos:

id

user_id (FK users)

app_id (FK apps)

timestamps

unique(user_id, app_id)

4.3 Seeder obrigatório

Seeder AppSeeder que cria/atualiza:

system

vendas

Regra: apps não pode depender de cadastro via UI; é seed.

5) Controllers e Views (MVP limpo)
5.1 LoginController (único)

showLoginForm(Request $request)

obtém $app = $request->route('app')

renderiza auth/login.blade.php com branding pelo $app

login(Request $request)

valida email e password

Auth::attempt($credentials)

session()->regenerate()

redirect para /{app}

logout(Request $request)

recebe app do form POST

faz logout padrão

redirect /{app}/login

5.2 Controllers de app

SystemController@index → dashboard simples

VendasController@index → dashboard simples

5.3 Views

resources/views/auth/login.blade.php
Um template único que muda cor/título baseado em $app.

resources/views/system/dashboard.blade.php

resources/views/vendas/dashboard.blade.php

Os dashboards devem conter:

título do app

link “Clientes” (pode ser placeholder no início)

botão logout enviando hidden app correto

6) Rotas do App (mínimo)
6.1 System (routes/system.php)

GET /system/login → LoginController@showLoginForm
name system.login defaults app=system

POST /system/login → LoginController@login
name system.login.submit defaults app=system

GET /system → SystemController@index
name system.dashboard defaults app=system

Todas dentro de prefix system.

6.2 Vendas (routes/vendas.php)

GET /vendas/login → LoginController@showLoginForm
name vendas.login defaults app=vendas

POST /vendas/login → LoginController@login
name vendas.login.submit defaults app=vendas

GET /vendas → VendasController@index
name vendas.dashboard defaults app=vendas

6.3 Logout

POST /logout → LoginController@logout
name logout (global)

7) Aplicação do Middleware Único (regra)

Aplicar context.access nas rotas de app (system e vendas) em nível de group/prefix:

Deve proteger:

/{app} e /{app}/...

Deve tratar login e core dentro dele (ver regra do middleware)

Não aplicar no routes/web.php institucional público.

8) Próxima etapa após login finalizado

Depois de tudo acima funcionando:

Criar CRUD mínimo de Cliente apenas dentro de /system:

migration clients (name, cpf unique, email, phone, city)

ClientController (index/create/store/edit/update/destroy)

views simples em resources/views/system/clients/*

rotas sob /system/clients... com defaults app=system

Ainda NÃO implementar roles/permissions aqui.

O CRUD serve para validar o pipeline:

auth

context

acesso app via BD

Só depois disso começar roles/permissions.

9) Entregáveis exigidos da IA (obrigatório)

Ao implementar, a IA deve entregar:

Cada arquivo com:

caminho completo

código completo

Comandos PowerShell para:

migrations

seeders

migrate

seed

Não omitir nada.

Não criar código pela metade.

Não sugerir pacotes de scaffold de auth (Breeze/Jetstream).

10) Critérios de aceitação (testes manuais)

Acessar /system sem login → redireciona /system/login

Acessar /vendas sem login → redireciona /vendas/login

Logar em /system/login com credenciais válidas:

redireciona /system

Estando logado, acessar /system/login:

redireciona /system (não mostra login)

Estando logado, acessar /vendas:

se usuário tem vendas em app_user → entra

se não tem → abort 403

Logout no dashboard:

volta para /{app}/login correto

Apps são seedados e code bate com o prefixo real.

IMPORTANTE: Tom e método

Este projeto foi construído com mentalidade de:

pipeline

lifecycle

request flow

centralização de regras

arquitetura explícita

A IA deve respeitar esse espírito.

FIM DO BLUEPRINT.

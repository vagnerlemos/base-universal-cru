30 MINUTOS PARA INSTALAR


01-no terminal vscode entre na pasta
    cd C:\xampp8212\htdocs

        composer create-project laravel/laravel "base_universal_v4" "10.*"

        code C:\xampp8212\apache\conf\extra\httpd-vhosts.conf

            //no final do arquivo acrescente:
            <VirtualHost *:80>
                ServerName v4-foodstorebrasil.com.br
                ServerAlias www.v4-foodstorebrasil.com.br

                DocumentRoot "C:/xampp8212/htdocs/base_universal_v4/public"

                <Directory "C:/xampp8212/htdocs/base_universal_v4/public">
                    AllowOverride All
                    Require all granted
                </Directory>

                ErrorLog "logs/base_universal_v4_error.log"
                CustomLog "logs/base_universal_v4_access.log" common
            </VirtualHost>


02-no bloco de notas entre como administrador
    abra este arquivo:
    C:\Windows\System32\drivers\etc\hosts
        No final do arquivo, adicione:
        127.0.0.1 v4.foodstorebrasil.com.br
        127.0.0.1 www.v4.foodstorebrasil.com.br



03-  cd C:\xampp8212\htdocs\base_universal_v4

04 - code .

05-Ajustar o .env do Laravel
    APP_NAME="Base v4"  (atenção coloque entre aspas "" tudo que tiver espaço)
    APP_URL=http://v4.foodstorebrasil.com.br
    DB_DATABASE=kaiser_core_v4

06-limpar cache:
    php artisan optimize:clear  
        
07-Reiniciar o Apache (obrigatório)  

08- http://localhost/phpmyadmin/
    NOVO
        kaiser_core_v4

09- EXPLOORE DO WINDOWS
    C:\xampp8212\htdocs
        Copie a pasta doc para o novo projeto

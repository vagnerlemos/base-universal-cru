## Site
## instalação:
    Pastas novas
        app/Http/Controllers/   Site/HomeController.php
        resources/views/        site/home.blade.php
        routes/web.php          (editar)


    apague a rota que levava para a abertura padrao do laravel  de routes/web.php   

        Route::get('/', function () {
            return view('welcome');
        });



        fase mental que estou 
            preciso enterder o caminha desde a raiz ate a apresentacao do site
            preciso percorrer ponto a ponto     

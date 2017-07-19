<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Book.php";
    require_once __DIR__."/../src/Author.php";

    $server = "mysql:host=localhost:8889;dbname=library";
    $username = "root";
    $password = "root";
    $DB = new PDO($server, $username, $password);

    $app = new Silex\Application();

    $app->register(new Silex\Provider\TwigServiceProvider(), array(                          'twig.path'=>__DIR__."/../views"
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get('/', function() use($app) {
        return $app['twig']->render('index.html.twig');
    });

    $app->get('/books', function() use($app) {
        return $app['twig']->render('books.html.twig', array('books' => Book::getAll()));
    });

    $app->post("/books", function() use($app) {
        $title = $_POST['title'];
        $id = $_POST['id'];
        $book = new Book($title, $id);
        $book->save();
        return $app['twig']->render('books.html.twig', array('books' => Book::getAll()));
    });

    $app->post("/delete_books", function() use($app) {
        Book::deleteAll();
        return $app['twig']->render('index.html.twig');
    });

    $app->get("/books/{id}", function($id) use ($app) {
       $book = Book::find($id);
       return $app['twig']->render('book.html.twig', array('book' => $book));
   });

    $app->get("/books/{id}/edit", function($id) use ($app) {
        $book = Book::find($id);
        return $app['twig']->render('book_edit.html.twig', array('book' => $book));
    });

    $app->patch("/books/{id}", function($id) use ($app) {
        $title = $_POST['title'];
        $book = Book::find($id);
        $book->update($title);
        return $app['twig']->render('book.html.twig', array('book' => $book));
    });

    $app->delete("/books/{id}", function($id) use ($app) {
        $book = Book::find($id);
        $book->delete();
        return $app['twig']->render('index.html.twig', array('books' => Book::getAll()));
    });

    return $app;
?>

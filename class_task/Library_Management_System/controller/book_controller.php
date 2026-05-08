<?php
require_once '../model/book_model.php';

header('Content-Type: application/json');
error_reporting(E_ALL);

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'add':
        $title = trim($_POST['title']);
        $author = trim($_POST['author']);
        $category = trim($_POST['category']);
        $availability = $_POST['availability'];
        
        if (empty($title) || empty($author) || empty($category)) {
            echo json_encode(['success' => false, 'error' => 'All fields are required']);
            break;
        }
        
        $success = addBook($title, $author, $category, $availability);
        echo json_encode(['success' => $success]);
        break;
        
    case 'getAll':
        $books = getAllBooks();
        echo json_encode(['success' => true, 'books' => $books]);
        break;
        
    case 'getById':
        $id = (int)$_GET['id'];
        $book = getBookById($id);
        if ($book) {
            echo json_encode(['success' => true, 'book' => $book]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Book not found']);
        }
        break;
        
    case 'update':
        $id = (int)$_POST['id'];
        $title = trim($_POST['title']);
        $author = trim($_POST['author']);
        $category = trim($_POST['category']);
        $availability = $_POST['availability'];
        
        if (empty($title) || empty($author) || empty($category)) {
            echo json_encode(['success' => false, 'error' => 'All fields are required']);
            break;
        }
        
        $success = updateBook($id, $title, $author, $category, $availability);
        echo json_encode(['success' => $success]);
        break;
        
    case 'delete':
        $id = (int)$_POST['id'];
        $success = deleteBook($id);
        echo json_encode(['success' => $success]);
        break;
        
    default:
        echo json_encode(['success' => false, 'error' => 'Invalid action']);
}
?>
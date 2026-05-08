<?php
require_once 'db.php';

function addBook($title, $author, $category, $availability) {
    $conn = getDB();
    $stmt = mysqli_prepare($conn, "INSERT INTO books (title, author, category, availability) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssss", $title, $author, $category, $availability);
    $result = mysqli_stmt_execute($stmt);
    $error = mysqli_error($conn);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    
    if (!$result) {
        error_log("Database error in addBook: " . $error);
        return false;
    }
    return true;
}

function getAllBooks() {
    $conn = getDB();
    $result = mysqli_query($conn, "SELECT * FROM books ORDER BY id DESC");
    
    if (!$result) {
        error_log("Database error in getAllBooks: " . mysqli_error($conn));
        mysqli_close($conn);
        return [];
    }
    
    $books = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $books[] = $row;
    }
    mysqli_close($conn);
    return $books;
}

function getBookById($id) {
    $conn = getDB();
    $stmt = mysqli_prepare($conn, "SELECT * FROM books WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $book = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $book;
}

function updateBook($id, $title, $author, $category, $availability) {
    $conn = getDB();
    $stmt = mysqli_prepare($conn, "UPDATE books SET title=?, author=?, category=?, availability=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "ssssi", $title, $author, $category, $availability, $id);
    $result = mysqli_stmt_execute($stmt);
    $error = mysqli_error($conn);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    
    if (!$result) {
        error_log("Database error in updateBook: " . $error);
        return false;
    }
    return true;
}

function deleteBook($id) {
    $conn = getDB();
    $stmt = mysqli_prepare($conn, "DELETE FROM books WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    $result = mysqli_stmt_execute($stmt);
    $error = mysqli_error($conn);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    
    if (!$result) {
        error_log("Database error in deleteBook: " . $error);
        return false;
    }
    return true;
}
?>
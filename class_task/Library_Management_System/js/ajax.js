function loadBooks() {
    fetch('controller/book_controller.php?action=getAll')
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('booksTableBody');
            if (!data.success) {
                tbody.innerHTML = '<tr><td colspan="5">Error loading books</td></tr>';
                return;
            }
            
            if (data.books.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5">No books found. Add your first book above!</td></tr>';
                return;
            }
            
            tbody.innerHTML = '';
            data.books.forEach(book => {
                tbody.innerHTML += `
                    <tr>
                        <td>${escapeHtml(book.title)}</td>
                        <td>${escapeHtml(book.author)}</td>
                        <td>${escapeHtml(book.category)}</td>
                        <td>${book.availability}</td>
                        <td>
                            <button onclick="editBook(${book.id})" style="background:#28a745;">Edit</button>
                            <button onclick="deleteBook(${book.id})" style="background:#dc3545;">Delete</button>
                        </td>
                    </tr>
                `;
            });
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('booksTableBody').innerHTML = '<tr><td colspan="5">Error loading books</td></tr>';
        });
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function addBook(event) {
    event.preventDefault();
    const formData = new FormData(document.getElementById('bookForm'));
    formData.append('action', 'add');
    
    fetch('controller/book_controller.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Book added successfully');
            loadBooks();
            document.getElementById('bookForm').reset();
        } else {
            alert('Failed to add book: ' + (data.error || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error adding book');
    });
}

function deleteBook(id) {
    if (confirm('Are you sure you want to delete this book?')) {
        const formData = new FormData();
        formData.append('action', 'delete');
        formData.append('id', id);
        
        fetch('controller/book_controller.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Book deleted successfully');
                loadBooks();
            } else {
                alert('Delete failed');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting book');
        });
    }
}

function editBook(id) {
    fetch(`controller/book_controller.php?action=getById&id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.book) {
                const book = data.book;
                document.getElementById('updateId').value = book.id;
                document.getElementById('updateTitle').value = book.title;
                document.getElementById('updateAuthor').value = book.author;
                document.getElementById('updateCategory').value = book.category;
                document.getElementById('updateAvailability').value = book.availability;
                document.getElementById('updateForm').style.display = 'block';
                document.getElementById('updateForm').scrollIntoView({ behavior: 'smooth' });
            } else {
                alert('Failed to load book details');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading book details');
        });
}

function updateBook(event) {
    event.preventDefault();
    const formData = new FormData(document.getElementById('updateBookForm'));
    formData.append('action', 'update');
    
    fetch('controller/book_controller.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Book updated successfully');
            loadBooks();
            document.getElementById('updateForm').style.display = 'none';
            document.getElementById('updateBookForm').reset();
        } else {
            alert('Update failed: ' + (data.error || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating book');
    });
}

window.onload = loadBooks;
// Elements
const form = document.getElementById('student-form');
const rollInput = document.getElementById('roll-no');
const nameInput = document.getElementById('student-name');
const addBtn = document.getElementById('add-btn');
const searchInput = document.getElementById('search-input');
const studentList = document.getElementById('student-list');
const totalCountEl = document.getElementById('total-count');
const attendanceEl = document.getElementById('attendance-count');
const sortBtn = document.getElementById('sort-btn');
const highlightFirstBtn = document.getElementById('highlight-first-btn');

// Enable/disable Add button based on name input
nameInput.addEventListener('input', () => {
    addBtn.disabled = nameInput.value.trim() === '';
});

// Add student
form.addEventListener('submit', addStudent);

function addStudent(e) {
    e.preventDefault();

    const roll = rollInput.value.trim();
    const name = nameInput.value.trim();

    if (name === '') {
        alert('Please enter student name');
        return;
    }

    const li = document.createElement('li');
    li.classList.add('student-item');

    // Display format: "23-54266-3 – Mashkur"
    const displayText = roll ? `${roll} – ${name}` : name;

    const span = document.createElement('span');
    span.textContent = displayText;

    // Store data attributes for sorting & editing
    li.dataset.name = name.toLowerCase();
    li.dataset.roll = roll;
    li.dataset.fullname = name;

    // Checkbox for attendance
    const checkbox = document.createElement('input');
    checkbox.type = 'checkbox';
    checkbox.id = `present-${Date.now()}`; // unique id
    const label = document.createElement('label');
    label.htmlFor = checkbox.id;
    label.textContent = 'Present';
    label.style.marginRight = 'auto';

    checkbox.addEventListener('change', () => {
        li.classList.toggle('present', checkbox.checked);
        updateAttendanceCount();
    });

    // Edit button
    const editBtn = document.createElement('button');
    editBtn.textContent = 'Edit';
    editBtn.className = 'btn-edit';
    editBtn.addEventListener('click', () => editStudent(li, span));

    // Delete button
    const deleteBtn = document.createElement('button');
    deleteBtn.textContent = 'Delete';
    deleteBtn.className = 'btn-delete';
    deleteBtn.addEventListener('click', () => {
        if (confirm('Are you sure you want to delete this student?')) {
            li.remove();
            updateTotalCount();
            updateAttendanceCount();
        }
    });

    const actions = document.createElement('div');
    actions.className = 'actions';
    actions.append(editBtn, deleteBtn);

    li.append(checkbox, label, span, actions);
    studentList.appendChild(li);

    // Reset form
    rollInput.value = '';
    nameInput.value = '';
    addBtn.disabled = true;

    updateTotalCount();
    updateAttendanceCount();
}

// Edit student
function editStudent(li, spanElement) {
    const currentName = li.dataset.fullname;
    const currentRoll = li.dataset.roll;

    const newRoll = prompt('Enter new Roll No (leave empty if none):', currentRoll);
    const newName = prompt('Enter new name:', currentName);

    if (newName === null || newName.trim() === '') return;

    const finalRoll = (newRoll || '').trim();
    const finalName = newName.trim();

    spanElement.textContent = finalRoll ? `${finalRoll} – ${finalName}` : finalName;

    // Update data attributes (used for sorting)
    li.dataset.name = finalName.toLowerCase();
    li.dataset.roll = finalRoll;
    li.dataset.fullname = finalName;
}

// Update total count
function updateTotalCount() {
    const count = studentList.children.length;
    totalCountEl.textContent = `Total students: ${count}`;
}

// Update attendance count
function updateAttendanceCount() {
    const present = document.querySelectorAll('.student-item.present').length;
    const total = studentList.children.length;
    const absent = total - present;
    attendanceEl.textContent = `Present: ${present}, Absent: ${absent}`;
}

// Search / filter
searchInput.addEventListener('input', () => {
    const term = searchInput.value.toLowerCase().trim();

    Array.from(studentList.children).forEach(li => {
        const name = li.dataset.name || '';
        li.style.display = name.includes(term) ? '' : 'none';
    });
});

// Sort alphabetically by name
sortBtn.addEventListener('click', () => {
    const items = Array.from(studentList.children);

    items.sort((a, b) => {
        const nameA = a.dataset.name || '';
        const nameB = b.dataset.name || '';
        return nameA.localeCompare(nameB);
    });

    studentList.innerHTML = '';
    items.forEach(item => studentList.appendChild(item));
});

// Highlight first student
highlightFirstBtn.addEventListener('click', () => {
    // Remove previous special highlight
    document.querySelectorAll('.highlight-first').forEach(el => {
        el.classList.remove('highlight-first');
    });

    if (studentList.children.length > 0) {
        studentList.children[0].classList.add('highlight-first');
    }
});
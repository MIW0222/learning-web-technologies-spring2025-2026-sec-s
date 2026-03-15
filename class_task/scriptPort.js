// ================= THEME TOGGLE =================
const themeToggle = document.getElementById('theme-toggle');
const body = document.body;

function setTheme(isDark) {
    if (isDark) {
        body.classList.add('dark');
        themeToggle.textContent = 'Light Mode';
        localStorage.setItem('theme', 'dark');
    } else {
        body.classList.remove('dark');
        themeToggle.textContent = 'Dark Mode';
        localStorage.setItem('theme', 'light');
    }
}

const savedTheme = localStorage.getItem('theme');
if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    setTheme(true);
} else {
    setTheme(false);
}

themeToggle.addEventListener('click', () => {
    setTheme(!body.classList.contains('dark'));
});

// ================= DYNAMIC PROJECT CARDS =================
const projects = [
    {
        title: "Student Registration System",
        description: "Semantic HTML5 form with validation styling, responsive layout, field grouping, and accessible controls.",
        image: "Student_Registration.png",
        link: "lt_1_1_[23_54266_3].html"
    },
    {
        title: "Interactive Student Attendance Tracker",
        description: "DOM-based application to add, edit, delete students, mark attendance, search, sort, and highlight entries.",
        image: "Student_Attendance.png",
        link: "DOM_Lab_Task.html"
    },
    {
        title: "Personal Academic Portfolio",
        description: "Clean, semantic single-page portfolio with responsive navigation, contact form, and theme switching.",
        image: "Academic_Portfolio.png",
        link: "lt_2_1_[23_54266_3].html"
    }
];

const projectsContainer = document.getElementById('projects-container');

function renderProjects() {
    projectsContainer.innerHTML = '';
    
    projects.forEach(project => {
        const card = document.createElement('div');
        card.className = 'project-card';
        
        card.innerHTML = `
            <img src="${project.image}" alt="${project.title}">
            <div class="project-info">
                <h3>${project.title}</h3>
                <p>${project.description}</p>
                <a href="${project.link}" class="project-link" target="_blank">View Project →</a>
            </div>
        `;
        
        projectsContainer.appendChild(card);
    });
}

renderProjects();

// ================= FORM VALIDATION =================
const form = document.getElementById('contact-form');
const nameInput = document.getElementById('name');
const emailInput = document.getElementById('email');
const subjectInput = document.getElementById('subject');
const messageInput = document.getElementById('message');

function showError(elementId, message) {
    document.getElementById(elementId).textContent = message;
}

function clearError(elementId) {
    document.getElementById(elementId).textContent = '';
}

function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

form.addEventListener('submit', function(e) {
    e.preventDefault();
    
    let isValid = true;
    
    // Name
    if (nameInput.value.trim() === '') {
        showError('name-error', 'Name is required');
        isValid = false;
    } else {
        clearError('name-error');
    }
    
    // Email
    if (emailInput.value.trim() === '') {
        showError('email-error', 'Email is required');
        isValid = false;
    } else if (!validateEmail(emailInput.value.trim())) {
        showError('email-error', 'Please enter a valid email');
        isValid = false;
    } else {
        clearError('email-error');
    }
    
    // Subject
    if (subjectInput.value.trim() === '') {
        showError('subject-error', 'Subject is required');
        isValid = false;
    } else {
        clearError('subject-error');
    }
    
    // Message
    if (messageInput.value.trim() === '') {
        showError('message-error', 'Message is required');
        isValid = false;
    } else if (messageInput.value.trim().length < 10) {
        showError('message-error', 'Message should be at least 10 characters');
        isValid = false;
    } else {
        clearError('message-error');
    }
    
    if (isValid) {
        alert('Form submitted successfully! (This is a demo)');
        form.reset();
    }
});

// ================= SCROLL TO TOP =================
const scrollTopBtn = document.getElementById('scroll-top');

window.addEventListener('scroll', () => {
    if (window.scrollY > 400) {
        scrollTopBtn.classList.add('show');
    } else {
        scrollTopBtn.classList.remove('show');
    }
});

scrollTopBtn.addEventListener('click', () => {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});
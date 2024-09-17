// Function to format numbers with leading zeros
function addLeadingZero(number) {
    return number < 10 ? `0${number}` : number;
}

// Function to update countdown display
function updateCountdown() {
    const countdownElement = document.getElementById("student-name");

    // Get the current date and time
    const now = new Date().getTime();
    const timeLeft = deadlineDate - now;

    if (timeLeft > 0) {
        const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
        const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

        countdownElement.placeholder =
            `Deadline: ${days} days ${addLeadingZero(hours)}:${addLeadingZero(minutes)}:${addLeadingZero(seconds)}`;
    } else {
        clearInterval(countdownInterval);
        countdownElement.placeholder = "Deadline has passed!";
    }
}

// Function to validate the student ID and auto-fill the student name
function validateAndAutoFill() {
    const studentIdInput = document.getElementById("student-id").value;
    const studentNameInput = document.getElementById("student-name");

    if (studentIdInput.length === 12) {
        const rows = document.querySelectorAll(".scrollingArea table tbody tr");
        let found = false;

        rows.forEach(row => {
            const idCell = row.cells[0].innerText;
            const nameCell = row.cells[1].innerText;

            if (idCell === studentIdInput) {
                studentNameInput.value = nameCell;
                studentNameInput.type = "text"
                studentNameInput.style.color = "";
                found = true;
            }
        });

        if (!found) {
            studentNameInput.type = "name"
            studentNameInput.value = "Student not found";
            studentNameInput.style.color = "red";
        }
    } else {
        studentNameInput.type = "name"
        studentNameInput.value = "";
        studentNameInput.style.color = "";
    }
}

// Function to check form inputs and shake the submit button if necessary
function checkFormAndShake(event) {
    const studentIdInput = document.getElementById("student-id");
    const studentNameInput = document.getElementById("student-name");
    const fileInput = document.getElementById("file-upload");
    const submitButton = document.getElementById("submit-button");

    if (studentIdInput.value.length !== 12) {
        event.preventDefault();
        studentIdInput.focus();
        shakeButton(submitButton);
    } else if (studentNameInput.value.trim() === "" || studentNameInput.style.color === "red") {
        event.preventDefault();
        studentIdInput.focus();
        shakeButton(submitButton);
    } else if (fileInput.files.length === 0) {
        event.preventDefault();
        fileInput.focus();
        shakeButton(submitButton);
    } else {
        console.log('Form is valid!');
    }
}

// Function to add a shake animation to the button
function shakeButton(button) {
    button.classList.add('shake');
    setTimeout(() => {
        button.classList.remove('shake');
    }, 500);
}

// Function to open the modal
function openModal() {
    document.getElementById("qrModal").style.display = "block";
}

// Function to close the modal
function closeModal() {
    document.getElementById("qrModal").style.display = "none";
}

// Close the modal if user clicks outside the modal content
window.onclick = function (event) {
    const modal = document.getElementById("qrModal");
    if (event.target === modal) {
        modal.style.display = "none";
    }
}

// Event listeners
document.getElementById("student-id").addEventListener("input", validateAndAutoFill);
document.getElementById("submit-button").addEventListener("click", (event) => {
    console.log('Button clicked!');
    checkFormAndShake(event);
});
document.getElementById('file-upload').addEventListener('change', function () {
    this.classList.toggle('selected', this.files.length > 0);
});

// Update the countdown every 1 second
const countdownInterval = setInterval(updateCountdown, 1000);
updateCountdown(); // Initialize countdown display

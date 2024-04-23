var dropbox = document.getElementById("dropbox");
var fileInput = document.getElementById("pdf_file");

dropbox.addEventListener("dragenter", function (e) {
    e.stopPropagation();
    e.preventDefault();
    dropbox.classList.add("dragover");
});

dropbox.addEventListener("dragover", function (e) {
    e.stopPropagation();
    e.preventDefault();
    dropbox.classList.add("dragover");
});

dropbox.addEventListener("dragleave", function (e) {
    e.stopPropagation();
    e.preventDefault();
    dropbox.classList.remove("dragover");
});

dropbox.addEventListener("drop", function (e) {
    e.stopPropagation();
    e.preventDefault();
    dropbox.classList.remove("dragover");

    var file = e.dataTransfer.files[0];
    if (file && file.type === "application/pdf") {
        updateDropbox(file.name);
        fileInput.files = e.dataTransfer.files; // Set the file input's files
        dropbox.classList.add("dragover");
    } else {
        alert("Hanya dapat menerima file pdf.");
    }
});

document.getElementById("pdf_file").addEventListener("change", function (e) {
    var file = e.target.files[0];
    if (file && file.type === "application/pdf") {
        updateDropbox(file.name);
        dropbox.classList.add("dragover");
    } else {
        alert("Hanya dapat menerima file pdf.");
    }
});

function updateDropbox(fileName) {
    var icon = document.querySelector(".dropbox-icon");
    icon.innerHTML = '<i class="bi bi-file-pdf red"></i>';

    var text = document.querySelector(".dropbox-text");
    text.textContent = fileName;
}
document.addEventListener("DOMContentLoaded", () => {
    initSearch();
    initPasswordModal();
    initTogglePassword();
});

const showAlert = (icon, title, message, confirm = false) => {
    return Swal.fire({
        icon,
        title,
        text: message,
        confirmButtonColor: "#3085d6",
        timer: confirm ? null : 2000,
        timerProgressBar: !confirm,
        showConfirmButton: confirm,
    });
};

/* ------------------------------------------
   1. SEARCH + SUGGESTIONS
------------------------------------------- */
function initSearch() {
    const input = document.querySelector(".search-input");
    const resetBtn = document.getElementById("resetSearch");
    const suggestionBox = document.querySelector(".search-suggestions");

    if (!input) return;

    input.addEventListener("input", () => {
        toggleResetButton(input, resetBtn);
        debounce(
            () => fetchSuggestions(input.value, suggestionBox, input),
            300
        )();
    });

    resetBtn.addEventListener("click", () =>
        resetSearch(input, resetBtn, suggestionBox)
    );

    document.addEventListener("click", (e) => {
        if (!e.target.closest(".search-wrapper"))
            suggestionBox.classList.add("d-none");
    });
}

function toggleResetButton(input, resetBtn) {
    resetBtn.classList.toggle("d-none", input.value === "");
}

function resetSearch(input, resetBtn, suggestionBox) {
    input.value = "";
    resetBtn.classList.add("d-none");
    suggestionBox.classList.add("d-none");
    input.focus();
}

function fetchSuggestions(query, suggestionBox, input) {
    if (query.length < 2) return suggestionBox.classList.add("d-none");

    const baseUrl = input.dataset.suggestUrl;
    const url = `${baseUrl}?q=${encodeURIComponent(query)}`;

    fetch(url)
        .then((res) => res.json())
        .then((data) => renderSuggestions(data, suggestionBox, input))
        .catch(() => suggestionBox.classList.add("d-none"));
}

function renderSuggestions(data, suggestionBox, input) {
    suggestionBox.innerHTML = "";

    if (!data.length) return suggestionBox.classList.add("d-none");

    data.forEach((item) => {
        const li = document.createElement("li");
        li.innerHTML = `<i class="mdi mdi-file-document-outline"></i> ${item.title}`;
        li.addEventListener("click", () => {
            input.value = item.title;
            suggestionBox.classList.add("d-none");
            input.closest("form").submit();
        });
        suggestionBox.appendChild(li);
    });

    suggestionBox.classList.remove("d-none");
}

// Debounce helper
function debounce(fn, delay) {
    let timeout;
    return () => {
        clearTimeout(timeout);
        timeout = setTimeout(fn, delay);
    };
}

/* ------------------------------------------
   3. PASSWORD MODAL HANDLING
------------------------------------------- */
function initPasswordModal() {
    const modal = document.getElementById("passwordModal");
    const passwordInput = document.getElementById("access_password");
    const documentIdInput = document.getElementById("document_id");

    if (!modal) return;

    modal.addEventListener("show.bs.modal", (event) => {
        documentIdInput.value = event.relatedTarget.dataset.id;
    });

    modal.addEventListener("hidden.bs.modal", () => {
        passwordInput.value = "";
        documentIdInput.value = "";
    });

    $("#passwordForm").on("submit", handlePasswordSubmit);
}

function handlePasswordSubmit(e) {
    e.preventDefault();

    $.ajax({
        url: this.action,
        type: "POST",
        data: $(this).serialize(),
        success: handlePasswordSuccess,
        error: handlePasswordError,
    });
}

function handlePasswordSuccess(response) {
    $("#passwordModal").modal("hide");

    showAlert("success", "Berhasil!", response.message).then(() => {
        window.location.href = response.download_url;
    });
}

function handlePasswordError(xhr) {
    const response = xhr.responseJSON;

    if (xhr.status === 429) {
        return Swal.fire({
            icon: "warning",
            title: "Terlalu Banyak Percobaan!",
            text: response?.message,
        });
    }
    if (xhr.status === 401) {
        return Swal.fire({
            icon: "error",
            title: "Password Salah!",
            text: response?.message,
        });
    }

    Swal.fire({
        icon: "error",
        title: "Gagal!",
        text: response?.message || "Terjadi kesalahan.",
    });
}

/* ------------------------------------------
   4. SHOW/HIDE PASSWORD (ADDED)
------------------------------------------- */
function initTogglePassword() {
    const input = document.getElementById("access_password");
    const toggleBtn = document.getElementById("togglePassword");

    if (!input || !toggleBtn) return;

    toggleBtn.addEventListener("click", () => {
        const isHidden = input.type === "password";
        input.type = isHidden ? "text" : "password";

        toggleBtn.classList.toggle("ri-eye-line");
        toggleBtn.classList.toggle("ri-eye-close-line");
    });
}

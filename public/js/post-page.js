document.addEventListener("DOMContentLoaded", () => {
    initPostSearch();
});

/* ------------------------------------------
   1. SEARCH + AUTOSUGGEST FOR POSTS
------------------------------------------- */
function initPostSearch() {
    const input = document.querySelector(".search-input");
    const resetBtn = document.getElementById("resetSearch");
    const suggestionBox = document.querySelector(".search-suggestions");

    if (!input) return;

    input.addEventListener("input", () => {
        toggleResetButton(input, resetBtn);
        debounce(
            () => fetchPostSuggestions(input.value, suggestionBox, input),
            250
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

function fetchPostSuggestions(query, suggestionBox, input) {
    if (query.length < 2) {
        suggestionBox.classList.add("d-none");
        return;
    }

    const url =
        input.dataset.suggestUrl.trim() + "?q=" + encodeURIComponent(query);

    fetch(url)
        .then((res) => res.json())
        .then((data) => renderPostSuggestions(data, suggestionBox, input))
        .catch(() => suggestionBox.classList.add("d-none"));
}

function renderPostSuggestions(data, suggestionBox, input) {
    suggestionBox.innerHTML = "";

    if (!data.length) return suggestionBox.classList.add("d-none");

    data.forEach((item) => {
        const li = document.createElement("li");
        li.innerHTML = `<i class="mdi mdi-newspaper-variant-outline"></i> ${item.title}`;
        li.addEventListener("click", () => {
            input.value = item.title;
            suggestionBox.classList.add("d-none");
            input.closest("form").submit();
        });
        suggestionBox.appendChild(li);
    });

    suggestionBox.classList.remove("d-none");
}

function debounce(fn, delay) {
    let timeout;
    return () => {
        clearTimeout(timeout);
        timeout = setTimeout(fn, delay);
    };
}

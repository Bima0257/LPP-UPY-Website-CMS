document.addEventListener("DOMContentLoaded", () => {
    /* ==========================================================
     *  Helper Functions
     * ========================================================== */

    const updateIndicators = (carousel, selectors) => {
        const carouselElement = document.querySelector(carousel);
        if (!carouselElement) return;

        const indicators = document.querySelectorAll(selectors);

        carouselElement.addEventListener("slide.bs.carousel", (e) => {
            indicators.forEach((indicator, index) => {
                const active = index === e.to;
                indicator.classList.toggle("active", active);
                indicator.setAttribute(
                    "aria-current",
                    active ? "true" : "false"
                );
            });
        });
    };

    const toggleText = (btn, shortText, fullText, card) => {
        const expanded = btn.textContent.trim() !== "Lihat Selengkapnya";

        btn.textContent = expanded
            ? "Lihat Selengkapnya"
            : "Tampilkan Lebih Sedikit";
        card.classList.toggle("expanded", !expanded);
        return expanded ? shortText : fullText;
    };

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

    const submitDownloadForm = (url, token) => {
        const form = document.createElement("form");
        form.method = "POST";
        form.action = url;

        const csrfInput = document.createElement("input");
        csrfInput.type = "hidden";
        csrfInput.name = "_token";
        csrfInput.value = token;
        form.appendChild(csrfInput);

        document.body.appendChild(form);
        form.submit();
    };

    /* ==========================================================
     *  Carousel Controls
     * ========================================================== */

    updateIndicators(
        "#blogCarousel",
        ".d-none.d-md-flex .post-carousel-indicators button"
    );
    updateIndicators(
        "#blogCarouselMobile",
        ".d-md-none.d-flex .post-carousel-indicators button"
    );

    /* ==========================================================
     *  Toggling Card Descriptions
     * ========================================================== */

    document.querySelectorAll('[id^="toggle-desc-"]').forEach((button) => {
        button.addEventListener("click", () => {
            const id = button.id.replace("toggle-desc-", "");
            const desc = document.getElementById(`desc-${id}`);
            const card = button.closest(".ud-single-feature");

            desc.textContent = toggleText(
                button,
                button.dataset.short,
                button.dataset.full,
                card
            );
        });
    });

    /* ==========================================================
     *  Password Modal Logic
     * ========================================================== */

    const passwordModal = document.getElementById("passwordModal");
    const passwordInput = document.getElementById("access_password");
    const documentIdInput = document.getElementById("document_id");
    const togglePassword = document.getElementById("togglePassword");


    // When modal opens → set doc ID
    passwordModal?.addEventListener("show.bs.modal", (event) => {
        documentIdInput.value =
            event.relatedTarget?.getAttribute("data-id") || "";
    });

    // When modal closes → reset fields
    passwordModal?.addEventListener("hidden.bs.modal", () => {
        passwordInput.value = "";
        documentIdInput.value = "";
    });

    /* ==========================================================
     *  AJAX Password Submit
     * ========================================================== */

    $("#passwordForm").on("submit", function (e) {
        e.preventDefault();

        let verifyUrl = $(this).data("verify-url");

        $.ajax({
            url: verifyUrl,
            type: "POST",
            data: $(this).serialize(),

            success: (response) => {
                if (response.status === "success") {
                    $("#passwordModal").modal("hide");

                    showAlert("success", "Berhasil!", response.message).then(
                        () => {
                            window.location.href = response.download_url;
                        }
                    );
                }
            },

            error: (xhr) => {
                const response = xhr.responseJSON;

                if (xhr.status === 429) {
                    return showAlert(
                        "warning",
                        "Terlalu Banyak Percobaan!",
                        response?.message || "Silakan coba lagi nanti.",
                        true
                    );
                }

                if (xhr.status === 401) {
                    return showAlert(
                        "error",
                        "Password Salah!",
                        response?.message || "Coba lagi.",
                        true
                    );
                }

                showAlert(
                    "error",
                    "Gagal!",
                    response?.message || "Terjadi kesalahan.",
                    true
                );
            },
        });
    });

    togglePassword.addEventListener("click", function () {
        const isPassword = passwordInput.type === "password";

        passwordInput.type = isPassword ? "text" : "password";

        // Ganti ikon
        this.classList.toggle("ri-eye-line");
        this.classList.toggle("ri-eye-close-line");
    });
});

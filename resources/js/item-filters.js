document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector('form[action*="items"]');
    const gridWrapper = document.querySelector("#item-grid-wrapper");

    if (!form || !gridWrapper) return;

    const fetchItems = (page = 1) => {
        const formData = new FormData(form);
        formData.set("page", page); // override or add page param
        const params = new URLSearchParams(formData).toString();

        fetch(`${form.action}?${params}`, {
            headers: { "X-Requested-With": "XMLHttpRequest" },
        })
            .then((response) => response.text())
            .then((html) => {
                gridWrapper.innerHTML = html;
                history.replaceState(null, "", `${form.action}?${params}`);
            })
            .catch((err) => console.error("AJAX error:", err));
    };

    // Trigger search on typing
    const searchInput = form.querySelector('input[name="search"]');
    if (searchInput) {
        let debounceTimer;
        searchInput.addEventListener("input", () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => fetchItems(), 300);
        });
    }

    // Trigger on dropdown change
    form.querySelectorAll("select").forEach((select) => {
        select.addEventListener("change", () => fetchItems());
    });

    // Prevent default submit
    form.addEventListener("submit", (e) => {
        e.preventDefault();
        fetchItems();
    });

    // AJAX pagination click handler s
    gridWrapper.addEventListener("click", function (e) {
        const link = e.target.closest("a[href]");
        if (link && link.closest(".pagination")) {
            e.preventDefault();
            const url = new URL(link.href);
            const page = url.searchParams.get("page");
            if (page) fetchItems(page);
        }
    });
});

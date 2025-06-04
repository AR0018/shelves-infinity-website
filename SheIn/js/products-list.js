// Global variables declaration
let loadedProducts = null;
let searchedGenre = null;
let includedCategories = null;
let includedGenres = null;

const open_filter_btn = document.getElementById("open-filter-button");
const h3_side_filter = document.querySelector("main > #filters-inputs > h3");
const filter_header = document.getElementById("filter-header");
const form_filter = document.querySelector("main > #filters-inputs > form");
const close_filter_btn = document.getElementById("close-filter-button");
const side_filter = document.querySelector("main > #filters-inputs");

open_filter_btn.addEventListener("click", openFilters);

/**
 * Function to open the filters sections.
 */
function openFilters() {
    open_filter_btn.style.display = "none";
    h3_side_filter.style.display = "none";
    filter_header.style.display = "flex";
    form_filter.style.display = "block";
    side_filter.style.display = "block";
    if (window.matchMedia("(min-width: 730px)")) {
        side_filter.style.width = "635px";
    }
}

close_filter_btn.addEventListener("click", closeFilters);

/**
 * Function to close the filters section.
 */
function closeFilters() {
    open_filter_btn.style.display = "block";
    h3_side_filter.style.display = "inline";
    filter_header.style.display = "none";
    form_filter.style.display = "none";
    side_filter.style.display = "flex";
    if (window.matchMedia("(min-width: 730px)")) {
        side_filter.style.width = "250px";
    }
}

/**
 * Returns an array containing every item that has been selected with a checkbox.
 * @param {Array} includedElements an array containing every item that corresponds to a checkbox
 * @returns {Array} the array of checked items
 */
function getCheckedElements(includedElements) {
    let selectedItems = [];
    if(includedElements) {
        for(let i = 0; i < includedElements.length; i++) {
            const checkbox = document.getElementById(getNameID(includedElements[i]));
            if(checkbox && checkbox.checked) {
                selectedItems.push(includedElements[i]);
            }
        }
    }

    return selectedItems;
}

/**
 * Filters the loaded products based on the values of the filters form.
 */
function applyFilters() {
    const minPrice = document.getElementById("min-price-range").value;
    const maxPrice = document.getElementById("max-price-range").value;
    const minRating = document.getElementById("min-rating-range").value;
    const disableRatingFilter = minRating < 1;
    const selectedCategories = getCheckedElements(includedCategories);
    const selectedGenres = getCheckedElements(includedGenres);
    const displayOnlyAvailable = document.getElementById("availability-checkbox").checked;

    const filteredProducts = loadedProducts
        .filter((p) => p.prezzo >= minPrice && p.prezzo <= maxPrice)
        .filter((p) => disableRatingFilter || (p.punteggio_medio && p.punteggio_medio >= minRating))
        .filter((p) => selectedCategories.includes(p.categoria) || selectedCategories.length === 0)
        .filter((p) => p.generi.some((g) => selectedGenres.includes(g.genere)) || selectedGenres.length === 0)
        .filter((p) => !displayOnlyAvailable || p.quantita_disponibile);
    showProducts(filteredProducts);
}

/**
 * Generates the string of the HTML article corresponding to the given product
 * @param {Object} product the given product
 * @returns {String} the HTML article string
 */
function generateProductArticle(product) {

    // Generate genres list. Shows a maximum of 2 genres, and adds three dots if there are more.
    const maxGenreNumber = 2;
    let genresList = "<ul>";
    let index;
    for(index = 0; index < product.generi.length && index < maxGenreNumber; index++) {
        genresList += `<li>${product.generi[index].genere}</li>`;
    }
    if(index < product.generi.length) {
        genresList += `<li>...</li>`
    }
    genresList += "</ul>";

    // Generate rating
    let ratingText = "<p>Valutazione: ";
    if(product.punteggio_medio) {
        ratingText += `<strong>${product.punteggio_medio.toFixed(1)}</strong> `;
        for(let i = 0; i < 5; i++) {
            ratingText += i < product.punteggio_medio ?
                '<span class="fa fa-star checked"></span>'
                : '<span class="fa fa-star"></span>';
        }
    } else {
        ratingText += "<strong>Nessuna recensione</strong>";
    }
    ratingText += "</p>";

    const productArticle =  `
        <article>
            <h3><a href="../products/product.php?id=${product.id}">${product.nome}</a></h3>
            <div><img src="${product.immagine}" alt=""/></div>
            <aside>
                <p>Generi:</p>
                ${genresList}
                ${ratingText}
                <p>Prezzo: <strong>${product.prezzo}€</strong></p>
            </aside>
            <a href="../products/product.php?id=${product.id}"><strong>Dettagli prodotto</strong></a>
        </article>`;
    return productArticle;
}

/**
 * Inserts in the page all the products in the input array
 * @param {Array} products the array of products to show
 */
function showProducts(products) {
    const articlesContainer = document.getElementById("search-product-ctn");

    articlesContainer.innerHTML = "";

    if(products && products.length) {
        for(let i = 0; i < products.length; i++) {
            articlesContainer.innerHTML += generateProductArticle(products[i]);
        }
    } else {
        const productsNotFoundText = `
            <p>Non è presente nessun prodotto che soddisfi i criteri di ricerca</p>`;
        articlesContainer.innerHTML = productsNotFoundText;
    }
}

/**
 * Returns the ID corresponding to the given name
 * @param {String} name the name to convert
 * @returns {String} the corresponding ID
 */
function getNameID(name) {
    return name.replace(/\s+/g, "_").toLowerCase();
}

/**
 * Insert in the specified HTML element the checkboxes corresponding to the items in the given array
 * @param {HTMLElement} containerElement the element in which to insert the checkboxes
 * @param {Array} items the array of items that must be put in the checkboxes
 */
function showCheckboxes(containerElement, items) {
    for(let i = 0; i < items.length; i++) {
        const item = items[i];
        // Creates the label for the checkbox
        const itemLabel = document.createElement("label");
        itemLabel.setAttribute("for", getNameID(item));
        itemLabel.innerText = item;
        // Creates the checkbox
        const itemCheckbox = document.createElement("input");
        itemCheckbox.setAttribute("type", "checkbox");
        itemCheckbox.setAttribute("name", getNameID(item));
        itemCheckbox.setAttribute("id", getNameID(item));
        itemCheckbox.setAttribute("value", item);
        // Inserts label and checkbox inside the container
        itemLabel.appendChild(itemCheckbox);
        containerElement.appendChild(itemLabel);
        
    }
}

/**
 * Sets the values of the inputs in the filters form based on the loaded products.
 */
function setFilterFormValues() {
    if(loadedProducts && loadedProducts.length > 0) {
        // Sets price filters' values
        const maxPrice = loadedProducts
            .map((p) => p.prezzo)
            .reduce((total, cur) => cur > total ? cur : total);
        document.getElementById("min-price-range").setAttribute("max", Math.floor(maxPrice));
        const maxPriceRange = document.getElementById("max-price-range");
        const maxPriceRangeValue = Math.ceil(maxPrice);
        maxPriceRange.setAttribute("max", maxPriceRangeValue);
        maxPriceRange.setAttribute("value", maxPriceRangeValue);
        document.getElementById("max-price-output").innerText = maxPriceRangeValue + " €";

        // Sets categories checkboxes
        const categoriesFieldset = document.getElementById("categories-filter");
        if(categoriesFieldset) {
            includedCategories = [];
            loadedProducts.forEach((p) => {
                if(!includedCategories.includes(p.categoria)) {
                    includedCategories.push(p.categoria);
                }
            });

            showCheckboxes(categoriesFieldset, includedCategories);
        }

        // Sets genres checkboxes
        includedGenres = [];
        loadedProducts.forEach((p) => {
            for(let i = 0; i < p.generi.length; i++) {
                if(!includedGenres.includes(p.generi[i].genere) && p.generi[i].genere != searchedGenre) {
                    includedGenres.push(p.generi[i].genere);
                }
            }
        });

        // Loads the genres checkboxes in the filter section
        const genresFieldset = document.getElementById("genres-filter");
        if(genresFieldset) {
            showCheckboxes(genresFieldset, includedGenres);
        }

        if(!includedGenres.length) {
            document.getElementById("genres-filter").remove();
        }
    } else {
        document.getElementById("filters-inputs").remove();
    }
}

/**
 * Loads all the products to list, based on the parameters passed in the URL.
 * Accepted parameters are:
 * - "categoria" -> loads every product of the given category
 * - "genere" -> loads every product with the given genre
 * - "nome" -> loads every product whose name matches with the given string
 * - no parameter -> loads every product in the store
 */
async function loadProducts() {
    let url = "products-list-api.php";
    const urlParams = new URLSearchParams(window.location.search);
    
    if(urlParams.get("categoria")) {
        url += `?categoria=${urlParams.get("categoria")}`;
    } else if(urlParams.get("genere")) {
        url += `?genere=${urlParams.get("genere")}`;
        searchedGenre = decodeURIComponent(urlParams.get("genere"));
    } else if(urlParams.get("nome") != null) {
        url += `?nome=${urlParams.get("nome")}`;
    }

    const response = await fetch(url);

    if(!response.ok) {
         new Error("Response status: " + response.status);
    }

    loadedProducts = await response.json();

    showProducts(loadedProducts);
    setFilterFormValues();
}

/**
 * Sets the handlers for every event in the page.
 */
function setHandlers() {
    document.getElementById("min-price-range")
        .addEventListener("input", (e) => {
            const priceOutput = document.getElementById("min-price-output");
            const maxPriceRange = document.getElementById("max-price-range");
            priceOutput.innerText = e.target.value + " €";
            maxPriceRange.setAttribute("min", e.target.value);
        });
    document.getElementById("max-price-range")
        .addEventListener("input", (e) => {
            const priceOutput = document.getElementById("max-price-output");
            const minPriceRange = document.getElementById("min-price-range");
            priceOutput.innerText = e.target.value + " €";
            minPriceRange.setAttribute("max", e.target.value);
        });
    document.getElementById("min-rating-range")
        .addEventListener("input", (e) => {
            const priceOutput = document.getElementById("min-rating-output");
            priceOutput.innerText = e.target.value == 0 ? "Qualsiasi punteggio" : e.target.value;
        });
    document.getElementById("apply-filters-button")
        .addEventListener("click", applyFilters);
}

setHandlers();
loadProducts();
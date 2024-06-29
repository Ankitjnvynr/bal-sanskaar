document.addEventListener('DOMContentLoaded', function () {
    // Get the search input element and item list
    var searchInput = document.getElementById("searchInput");
    var itemList = document.getElementById("itemList");

    // Function to filter items based on search input
    function filterItems() {
        var filterValue = searchInput.value.toLowerCase(); // Convert input to lowercase for case-insensitive comparison
        var items = itemList.getElementsByTagName("li");

        // Loop through all list items, and hide those that don't match the search query
        for (var i = 0; i < items.length; i++) {
            var item = items[i];
            var text = item.textContent.toLowerCase(); // Get text content of item and convert to lowercase

            if (text.includes(filterValue)) {
                item.style.display = ""; // Display item if it matches the search query
            } else {
                item.style.display = "none"; // Hide item if it doesn't match
            }
        }
    }

    // Event listener for keyup event on search input
    searchInput.addEventListener("keyup", filterItems);
});

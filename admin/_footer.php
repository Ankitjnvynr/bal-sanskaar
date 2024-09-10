

        </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
 <script src="../js/admin.js"></script>
 <script src="../js/script.js"></script>
 <script src="../js/selectOption.js"></script>
 <script>
  window.onload = function() {
   

    // Check if the page was reloaded manually by the user
    if (performance.navigation.type === performance.navigation.TYPE_RELOAD) {
        // Get the current URL parameters
        const urlParams = new URLSearchParams(window.location.search);

        // Keep only the 'data' and 'page' parameters, remove everything else
        const allowedParams = ['data', 'page'];
        const newParams = new URLSearchParams();

        allowedParams.forEach(param => {
            if (urlParams.has(param)) {
                newParams.set(param, urlParams.get(param)); // Retain only 'data' and 'page' if they exist
            }
        });

        // If the current URL has any other parameters, update the URL
        if (urlParams.toString() !== newParams.toString()) {
            // Redirect to the new URL with only 'data' and 'page'
            window.location.search = newParams.toString();
        }
    }
};

</script>
    
</body>

</html>
// Wait for the HTML to be fully loaded
document.addEventListener('DOMContentLoaded', () => {

    // --- 1. Select Our Elements ---
    
    // Get the "Show All" button
    const showAllButton = document.querySelector('#show-all');
    
    // Get all filter buttons *except* "Show All"
    // We use :not(#show-all) to exclude it
    const filterButtons = document.querySelectorAll('.search button:not(#show-all)');
    
    // Get all the recipe cards
    const recipeCards = document.querySelectorAll('.recipes .recipe-card');

    // --- 2. The Main Filtering Function ---
    
    const applyFilters = () => {
        
        // Get an array of all *active* filter texts (e.g., ["Chicken", "Roasted"])
        const activeFilters = [];
        filterButtons.forEach(button => {
            if (button.classList.contains('active')) {
                activeFilters.push(button.textContent.trim());
            }
        });

        // --- 3. Loop Through Cards and Show/Hide ---
        
        // Loop through each recipe card
        recipeCards.forEach(card => {
            
            // Get all the tag texts for *this* card
            const tagsOnCard = [];
            card.querySelectorAll('.recipe-tags li').forEach(tag => {
                tagsOnCard.push(tag.textContent.trim());
            });

            // This is the "AND" logic
            // .every() checks if *all* items in activeFilters pass the test
            const hasAllTags = activeFilters.every(filterTag => {
                return tagsOnCard.includes(filterTag);
            });

            // Show or hide the card
            // If there are no active filters, "hasAllTags" will be true (showing all)
            if (hasAllTags) {
                card.style.display = ''; // Show the card
            } else {
                card.style.display = 'none'; // Hide the card
            }
        });
    };

    // --- 4. Set Up Click Listeners ---

    // Listener for all *regular* filter buttons
    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            
            // Toggle the 'active' class on the clicked button
            button.classList.toggle('active');
            
            // If we just activated a filter, deactivate "Show All"
            if (button.classList.contains('active')) {
                showAllButton.classList.remove('active');
            }

            // Check if any other filters are active. If not, activate "Show All".
            const anyOtherFilterActive = Array.from(filterButtons).some(btn => btn.classList.contains('active'));
            if (!anyOtherFilterActive) {
                showAllButton.classList.add('active');
            }
            
            // Run the filter logic
            applyFilters();
        });
    });

    // Listener for the "Show All" button
    showAllButton.addEventListener('click', () => {
        // Deactivate all other filter buttons
        filterButtons.forEach(button => {
            button.classList.remove('active');
        });
        
        // Activate the "Show All" button
        showAllButton.classList.add('active');
        
        // Run the filter logic (which will show all cards)
        applyFilters();
    });

});
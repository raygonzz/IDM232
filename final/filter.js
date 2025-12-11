document.addEventListener('DOMContentLoaded', () => {

    const showAllButton = document.querySelector('#show-all');
    const filterButtons = document.querySelectorAll('.search button:not(#show-all)');
    const recipeCards = document.querySelectorAll('.recipes .recipe-card');
    const noResultsMessage = document.querySelector('#no-results-message');
    
    if (!noResultsMessage) {
        console.warn('The element #no-results-message was not found. The "no results" feature will not work.');
    }

    const applyFilters = () => {
        
        const activeFilters = [];
        filterButtons.forEach(button => {
            if (button.classList.contains('active')) {
                activeFilters.push(button.textContent.trim());
            }
        });

        let visibleCardCount = 0;

        recipeCards.forEach(card => {
            
            const tagsOnCard = [];
            card.querySelectorAll('.recipe-tags li').forEach(tag => {
                tagsOnCard.push(tag.textContent.trim());
            });

            // If activeFilters is empty, we effectively show nothing unless handled, 
            // but your logic relies on Show All button handling the "reset" state.
            // The logic below checks if the card matches ALL active filters.
            const hasAllTags = activeFilters.every(filterTag => {
                return tagsOnCard.includes(filterTag);
            });

            if (hasAllTags) {
                card.style.display = '';
                visibleCardCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (noResultsMessage) {
            if (visibleCardCount === 0) {
                noResultsMessage.style.display = 'block';
            } else {
                noResultsMessage.style.display = 'none';
            }
        }
    };

    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            
            button.classList.toggle('active');
            
            if (button.classList.contains('active')) {
                showAllButton.classList.remove('active');
            }

            const anyOtherFilterActive = Array.from(filterButtons).some(btn => btn.classList.contains('active'));
            if (!anyOtherFilterActive) {
                showAllButton.classList.add('active');
            }
            
            applyFilters();
        });
    });

    showAllButton.addEventListener('click', () => {
        filterButtons.forEach(button => {
            button.classList.remove('active');
        });
        
        showAllButton.classList.add('active');
        
        applyFilters();
    });

    /* =========================================================
       NEW CODE: URL PARAMETER HANDLING
       This reads ?filter=chicken from the URL and clicks the button
       ========================================================= */
    const urlParams = new URLSearchParams(window.location.search);
    const filterValue = urlParams.get('filter'); // Gets 'chicken', 'tacos', etc.

    if (filterValue) {
        // We use toLowerCase() to ensure it matches the class name (e.g., .filter-chicken)
        const targetButton = document.querySelector(`.filter-${filterValue.toLowerCase()}`);

        if (targetButton) {
            // Programmatically click the button to trigger all the logic above
            targetButton.click();
        }
    }

});
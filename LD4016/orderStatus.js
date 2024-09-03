

// Function to update status circles based on the current order status
function updateStatusCircles(status) {
    const circle1 = document.getElementById('circle1');
    const circle2 = document.getElementById('circle2');
    const circle3 = document.getElementById('circle3');

    // Update circles based on status
    if (status >= 2) {
        circle1.classList.add('green'); // First circle turns green
    }
    if (status >= 3) {
        circle2.classList.add('green'); // Second circle turns green
    }
    if (status >= 4) {
        circle3.classList.add('green'); // Third circle turns green
    }
}

// Example call to updateStatusCircles with status from the server
// Replace '3' with the actual status value fetched from your server logic
updateStatusCircles(3);

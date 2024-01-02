function executeScripts() {
    // Execute request.php
    $.ajax({
        url: 'request.php',
        success: function (data) {
            console.log('request.php executed');
            // Wait for 10 seconds before proceeding to formatter.php
            setTimeout(function () {
                // Execute formatter.php
                $.ajax({
                    url: 'formatter.php',
                    success: function (data) {
                        console.log('formatter.php executed');
                        // Wait for 10 seconds before proceeding to builder.php
                        setTimeout(function () {
                            // Execute builder.php
                            $.ajax({
                                url: 'builder.php',
                                success: function (data) {
                                    console.log('builder.php executed');
                                    // Wait for 10 seconds before proceeding to crypt.php
                                    setTimeout(function () {
                                        // Execute crypt.php
                                        $.ajax({
                                            url: 'crypt.php',
                                            success: function (data) {
                                                console.log('crypt.php executed');
                                                // Wait for 10 seconds before proceeding to sender.php
                                                setTimeout(function () {
                                                    // Execute sender.php
                                                    $.ajax({
                                                        url: 'sender.php',
                                                        success: function (data) {
                                                            console.log('sender.php executed');
                                                            
                                                            // After executing all PHP scripts, trigger update_time.php
                                                            // to update the last update time on the main page
                                                            $.ajax({
                                                                url: 'update_time.php',
                                                                success: function (data) {
                                                                    // Handle the response, e.g., update the last update time on the page
                                                                    console.log('update_time.php executed');
                                                                }
                                                            });
                                                        }
                                                    });
                                                }, 10000); // 10 seconds delay for sender.php
                                            }
                                        });
                                    }, 10000); // 10 seconds delay for crypt.php
                                }
                            });
                        }, 10000); // 10 seconds delay for builder.php
                    }
                });
            }, 10000); // 10 seconds delay for formatter.php
        }
    });
}

// Call the function initially
executeScripts();
console.log('Waiting');
// Schedule the function to run every hour (in milliseconds)
setInterval(executeScripts, 3600000); // 3600000 milliseconds = 1 hour

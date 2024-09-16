<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusher Messages</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Pusher Messages</h1>
        <ul id="messages" class="list-group mt-3">
            <!-- Messages sẽ được thêm vào đây -->
        </ul>
    </div>

    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        // Enable Pusher logging - don't include this in production
        Pusher.logToConsole = true;

        // Initialize Pusher
        var pusher = new Pusher('fe22582edf50b649adfb', {
            cluster: 'ap1'
        });

        // Subscribe to the channel
        var channel = pusher.subscribe('public-channel');

        // Bind to the event
        channel.bind('notification-event', function(data) {
            // Create a new list item for the message
            var newMessage = document.createElement('li');
            newMessage.className = 'list-group-item';
            newMessage.innerText = data.message;

            // Add the new message to the top of the list
            var messagesList = document.getElementById('messages');
            messagesList.insertBefore(newMessage, messagesList.firstChild);
        });
    </script>
</body>
</html>

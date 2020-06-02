<?php
$messages = [
    'hi' => 'Hello',
    'hello' => 'Hi!',
    'good morning' => 'Good morning',
    'whats you name' => 'Hi, my name is Siri!',
    'how old are you' => 'I\'m old enough to talk with you!',
    'i love you' => 'I love you too ^^',
    ':)' => ':p',
];

if (isset($_POST['message']) && $_POST['message']) {
    header('Content-Type: application/json');
    sleep(1);
    $message = trim(strtolower($_POST['message']));
    $message = str_replace(['?', '!', "'", ','], '', $message);
    foreach ($messages as $key => $value) {
        if ($key == $message) {
            echo json_encode([
                'message' => $value
            ]);
            exit;
        }
    }

    echo json_encode([
        'message' => 'Sorry! I don\'t understand your words!!'
    ]);
    exit;
}


?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>Chatbot</title>
</head>

<body>
    <main class="container">
        <div class="w-50  mx-auto bg-light">
            <div class="d-flex vh-100 flex-column py-3 px-1">
                <h1>Chatbot!</h1>
                <div class="flex-grow-1 overflow-auto border">
                    <div id="chatbox" class="p-1">
                    </div>
                </div>
                <div class="mt-1 p1">
                    <form method="post" action="" class="d-flex">
                        <input type="text" name="message" autocomplete="off" class="form-control flex-grow-1 mr-1">
                        <button type="submit" class="btn btn-outline-primary">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

    <script>
        $('form').on('submit', function(e) {
            e.preventDefault();
            let msg = $(this).find('[name=message]').val();
            $(this).find('[name=message]').val('');
            let date = new Date();
            $('#chatbox').append(`<div class="py-2 w-75 float-right text-right">
                            <span class="py-1 px-3 d-block-inline bg-success rounded">${msg}</span>
                            <br><span class="text-muted font-weight-light badge">${date.getHours()}:${date.getMinutes()}</span>
                        </div>`);
            $.ajax({
                url: "./chatbot.php",
                method: "post",
                data: {
                    message: msg
                }
            }).done(function(response) {
                let date = new Date();
                $('#chatbox').append(`<div class="py-2 w-75 float-left text-left">
                            <span class="py-1 px-3 d-block-inline bg-info rounded">${response.message}</span>
                            <br><span class="text-muted font-weight-light badge">${date.getHours()}:${date.getMinutes()}</span>
                        </div>`);
            })
        })
    </script>

</body>

</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap 4 Toast Example</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="myToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="3000">
            <div class="toast-header">
                <strong class="mr-auto">通知</strong>
                <small>剛剛</small>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                這是一個 Bootstrap 4 Toast 範例。
            </div>
        </div>
    </div>

    <button id="showToastBtn" class="btn btn-primary">顯示 Toast</button>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('showToastBtn').addEventListener('click', function () {
            console.log("showToastBtn is clicked");
            $('#myToast').toast('show');
        });
    </script>
</body>
</html>
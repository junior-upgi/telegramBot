<!DOCTYPE html>
<html lang="zh">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>TelegramBot</title>

        <!-- 最新編譯和最佳化的 CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

        <!-- 選擇性佈景主題 -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">

        <!-- 最新編譯和最佳化的 JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td>erp_id</td>
                        <td>姓名</td>
                        <td>Telegram_id</td>
                        <td>Telegram_username</td>
                    </tr>
                </thead>
                @foreach($user as $u)
                    <tr>
                        <td>{{ $u['ID'] }}</td>
                        <td>{{ $u['name'] }}</td>
                        <td>{{ $u['telegramID'] }}</td>
                        <td>{{ $u['username'] }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </body>
</html>

<!DOCTYPE HTML>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

</head>
<title>Untitled Document</title>

<body>

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f0f0f0;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    p {
        margin: 10px 0;
        padding: 0;
        font-weight: normal;
    }

    p {
        font-size: 13px;
    }
</style>

<!-- BODY-->
<div style="max-width: 700px; width: 100%; background: #fff;margin: 30px auto;">
    <div style="padding:30px 60px;">

        <p style="margin-top: 30px;"><strong>Dear {{ $recipientName }},</strong></p>

        <p>
            I found this article interesting and I would like to share with you.
        </p>

        <p>
            Please click on the button below to view the relevant details of the article.
        </p>

        <br>

        <div style="text-align: center;">
            <a href="{{ $news->get_url() }}" target="_blank" style="padding: 10px 20px; background: #0349fc; color: #fff;text-decoration: none;font-size: 14px; border-radius: 3px;">VIEW ARTICLE</a>
        </div>

        Thank you !
    </div>
</div>

</body>

</html>

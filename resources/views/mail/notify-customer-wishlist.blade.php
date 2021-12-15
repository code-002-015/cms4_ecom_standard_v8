<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title></title>
    </head>
    <body style="background:#FFFFFF;font-family:arial;">
    <p>&nbsp;</p>
    <table style="width:850px;margin:auto;background:#fff;border:1px solid #dddddd;padding:1em;-webkit-border-radius:5px;border-radius:5px;font-size:12px;">
        <tr>
            <td>
                <a href="{{ url('/') }}">
                    <img src="{{ asset('storage').'/logos/'.$setting->company_logo }}" alt="Sysu" width="175" />
                </a>
            </td>
        </tr>
        <tr>
            <td>
                Dear {{$customer->firstname}},
                <br>
                <br>
                Good Day!
                <br>
                <br>
                We are happy to notify you that <strong>{{ $product->name }}</strong> is back in stock.
                <br>
                <br>
                <p>
                    To go to the product click <a href="{{ route('product.front.show',$product->slug) }}">here</a>.
                    <br>
                    <br>
                    If you prefer not to receive notifications in the future, you can <a href="{{ route('profile.wishlist') }}">modify your wishlist settings</a>.
                </p>
                <br>
                <br>
                Thank you.
                <br>
                <br>
                <p>
                    <strong>
                        Regards, <br />
                        {{ $setting->company_name }}
                    </strong>
                </p>
            </td>
        </tr>
    </table>
    </body>
</html>
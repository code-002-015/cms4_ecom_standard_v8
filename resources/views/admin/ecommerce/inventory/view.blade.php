<html>
<head>
    <title>Inventory</title>
</head>
<body>
    <table width="50%" style="font: 15px Arial, sans-serif;">
        <tr style="font-weight:bold;">
            <td>ID</td>
            <td>Product</td>
            <td>Inventory</td>            
        </tr>
        <tr>
            <td colspan="3"><hr></td>
        </tr>
        @forelse($data as $d)
        <tr>
            <td>{{$d->product_id}}</td>
            <td>{{$d->product->name}}</td>
            <td>{{$d->inventory}}</td>
        </tr>
        @empty
        @endforelse
    </table>
</body>
</html>
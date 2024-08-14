<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Product Form | Laravel Test | Coalition Technologies</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="text-bg-light d-flex align-items-center justify-content-center p-2">
    <main class="container-fluid border border-dark rounded m-3 m-md-5 text-dark text-start p-2">
        <h1 class="">Product List</h1>
        <div class="container border-bottom border-secondary py-3">
            <h2>Add Product</h2>
            <form action="{{ route('products.store') }}" method="POST" class="d-flex flex-column mb-3">
                @csrf
                <div class="form-group mb-3">
                    <label for="productName" class="form-label">Product Name</label>
                    <input type="text" class="form-control" id="productName" name="productName" required>
                </div>
                <div class="form-group mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" required>
                </div>
                <div class="form-group mb-3">
                    <label for="price" class="form-label">Price per Item</label>
                    <input type="number" class="form-control" id="price" name="price" required>
                </div>
                <button type="submit" class="btn btn-primary mt-3 w-auto mx-auto">Submit</button>
            </form>
        </div>

        <div class="container mt-5">
            <h2>Product List</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity in Stock</th>
                        <th>Price per Item</th>
                        <th>Datetime Submitted</th>
                        <th>Total Value</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php $sumTotalValue = 0; @endphp
                    @foreach($products as $product)
                        @php $sumTotalValue += $product['totalValue']; @endphp
                        <tr>
                            <form action="/edit/{{ $product['id'] }}" method="POST">
                                @csrf
                                <td><input type="text" name="productName" value="{{ $product['productName'] }}" class="form-control" readonly></td>
                                <td><input type="number" name="quantity" value="{{ $product['quantity'] }}" class="form-control" readonly></td>
                                <td><input type="number" name="price" value="{{ $product['price'] }}" class="form-control" readonly></td>
                                <td>{{ $product['dateTimeSubmitted'] }}</td>
                                <td>{{ $product['totalValue'] }}</td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-edit">Edit</button>
                                    <button type="submit" class="btn btn-success btn-update" style="display: none;">Update</button>
                                </td>
                            </form>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="4"><strong>Total</strong></td>
                        <td colspan="2"><strong>{{ $sumTotalValue }}</strong></td>
                    </tr>
                    </tbody>
            </table>
        </div>
    </main>
</body>
</html>

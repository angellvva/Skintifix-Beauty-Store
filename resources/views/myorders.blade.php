<!-- resources/views/myorders.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h1>Your Orders</h1>

    <!-- Check if the user has orders -->
    @if($orders->isEmpty())
        <p>You have no orders yet.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->created_at }}</td>
                        <td>{{ $order->status }}</td>
                        <td>${{ $order->total }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination links if applicable -->
        <tfoot>
            <tr>
                <td colspan="4">{{ $orders->links() }}</td>
            </tr>
        </tfoot>
    @endif
</body>
</html>

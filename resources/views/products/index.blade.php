<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="flex flex-col items-center min-h-screen bg-gray-900 p-4 text-white">

    <div class="w-full max-w-4xl bg-gray-800 p-6 rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-semibold">Products</h2>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="button" onclick="openModal()"
                    class="mt-6 px-4 py-2 text-white bg-green-600 rounded-md hover:bg-green-700">
                    Add New
                </button>
                <button type="submit" class="px-4 py-2 text-white bg-red-600 rounded-md hover:bg-red-700">
                    Logout
                </button>
            </form>
        </div>

        @if ($errors->any())
            <p class="p-2 text-sm text-red-300 bg-red-700 border border-red-500 rounded mb-4">
                {{ $errors->first() }}
            </p>
        @endif

        <!-- Search Input -->
        <input type="text" id="searchInput" placeholder="Search by Name or Color..."
            class="w-full px-4 py-2 mb-4 border border-gray-600 bg-gray-700 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-400"
            onkeyup="filterProducts()">

        <div class="overflow-x-auto">
            <table class="w-full text-left border border-gray-600 rounded-lg shadow-md">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="px-4 py-2 border border-gray-600">Name</th>
                        <th class="px-4 py-2 border border-gray-600">Price</th>
                        <th class="px-4 py-2 border border-gray-600">Color</th>
                        <th class="px-4 py-2 border border-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody id="productTableBody">
                    @foreach ($products as $product)
                        <tr class="product-row hover:bg-gray-700">
                            <td class="px-4 py-2 border border-gray-600 product-name">
                                {{ $product['name'] ?? '-' }}
                                {{ isset($product['data']['Generation']) ? ' (' . $product['data']['Generation'] . ')' : '' }}
                                {{ isset($product['data']['Capacity']) ? ', ' . $product['data']['Capacity'] : '' }}

                            </td>
                            <td class="px-4 py-2 border border-gray-600">
                                {{ $product['data']['price'] ?? '-' }}
                            </td>
                            <td class="px-4 py-2 border border-gray-600 product-color">
                                {{ $product['data']['color'] ?? '-' }}
                            </td>
                            <td class="px-4 py-2 border border-gray-600">
                                <button onclick="editProduct('{{ $product['id'] }}')"
                                    class="px-3 py-1 text-white bg-blue-500 rounded-md hover:bg-blue-600">
                                    Edit
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL -->
    <div id="modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg w-96">
            <h3 id="modalTitle" class="text-xl font-semibold mb-4">Add New Product</h3>
            <form id="productForm" method="POST" action="/products" class="space-y-3">
                @csrf
                <input type="hidden" id="productId" name="id">
                <input type="text" id="productName" name="name" placeholder="Name" required
                    class="w-full px-4 py-2 border border-gray-600 bg-gray-700 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-400">
                <input type="number" id="productPrice" name="price" placeholder="Price" required
                    class="w-full px-4 py-2 border border-gray-600 bg-gray-700 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-400">
                <input type="text" id="productColor" name="color" placeholder="Color" required
                    class="w-full px-4 py-2 border border-gray-600 bg-gray-700 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-400">
                <div class="flex justify-between">
                    <button type="button" onclick="closeModal()"
                        class="px-4 py-2 text-white bg-gray-600 rounded-md hover:bg-gray-700">
                        Cancel
                    </button>
                    <button type="button" onclick="mutateProduct(event)" id="submitButton"
                        class="px-4 py-2 text-white bg-green-600 rounded-md hover:bg-green-700">
                        Add Product
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(id = null, name = '', price = '', color = '') {
            document.getElementById("modal").classList.remove("hidden");

            if (id) {
                document.getElementById("modalTitle").innerText = "Edit Product";
                document.getElementById("productForm").action = `/products/${id}`;
                document.getElementById("productId").value = id;
                document.getElementById("productName").value = name === '-' ? '' : name;
                document.getElementById("productPrice").value = price === '-' ? '' : price;
                document.getElementById("productColor").value = color === '-' ? '' : color;
                document.getElementById("submitButton").innerText = "Update Product";
            } else {
                document.getElementById("modalTitle").innerText = "Add New Product";
                document.getElementById("productForm").action = "/products";
                document.getElementById("productId").value = "";
                document.getElementById("productName").value = "";
                document.getElementById("productPrice").value = "";
                document.getElementById("productColor").value = "";
                document.getElementById("submitButton").innerText = "Add Product";
            }
        }

        function closeModal() {
            document.getElementById("modal").classList.add("hidden");
        }

        function editProduct(id) {
            let row = document.querySelector(`button[onclick="editProduct('${id}')"]`).closest("tr");
            let name = row.querySelector(".product-name").innerText;
            let price = row.querySelector("td:nth-child(2)").innerText;
            let color = row.querySelector(".product-color").innerText;

            openModal(id, name, price, color);
        }

        function filterProducts() {
            let searchValue = document.getElementById("searchInput").value.toLowerCase();
            let rows = document.querySelectorAll(".product-row");

            rows.forEach(row => {
                let name = row.querySelector(".product-name").innerText.toLowerCase();
                let color = row.querySelector(".product-color").innerText.toLowerCase();

                if (name.includes(searchValue) || color.includes(searchValue)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        }

        function mutateProduct(event) {
            event.preventDefault();
            let id = document.getElementById("productId").value;
            let url = id ? `/api/products/${id}` : "/api/products";
            let method = id ? "PUT" : "POST";

            let productName = document.getElementById("productName").value;
            let productPrice = document.getElementById("productPrice").value;
            let productColor = document.getElementById("productColor").value;

            fetch(url, {
                    method: method,
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        name: productName,
                        price: +productPrice,
                        color: productColor
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: "Success!",
                            text: id ? "Product updated successfully!" : "Product added successfully!",
                            icon: "success",
                            confirmButtonText: "OK"
                        }).then(() => {
                            closeModal();
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: "Error!",
                            text: "Failed to save product. Please try again. "+data?.error?.error,
                            icon: "error",
                            confirmButtonText: "OK"
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        title: "Error!",
                        text: "Something went wrong. Please check the console.",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                });
        }
    </script>

</body>

</html>

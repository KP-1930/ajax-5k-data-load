<!DOCTYPE html>

<html>

<head>

    <title>Laravel 8 Datatables Tutorial - ItSolutionStuff.com</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />

    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">

    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

</head>

<body>

    

<div class="container">

    <h1>Laravel 8 Datatables Tutorial <br/> ItSolutionStuff.com</h1>

    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Detail</th>
                <th width="100px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

   

</body>

   
<script type="text/javascript">
  $(function () {
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('products.index') }}",
            data: function (d) {
                // Send additional data if needed
            }
        },

        // Custom length menu to include the "All" option
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'slug', name: 'slug'},
            {data: 'detail', name: 'detail'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],

        // Lazy loading logic
        pageLength: 100,  // Load in chunks of 100 records at a time
        scrollY: "3000px",  // Enable vertical scrolling
        scrollCollapse: true,
        deferRender: true,
        scroller: true,
    });

    // Event listener for when a new page is loaded
    table.on('draw', function() {
        var info = table.page.info();
        // Check if the user selected "All" and is on the last page
        if (info.length === -1 && info.pages === info.page + 1) {
            loadMoreData();
        }
    });

    function loadMoreData() {
        // Get the current page and fetch the next set of data
        var currentPage = table.page.info().page;

        $.ajax({
            url: "{{ route('products.index') }}", // Adjust the URL as needed
            method: 'GET',
            data: {
                start: currentPage * 100,  // Start fetching from the next 100 records
                length: 100,               // Fetch 100 records at a time
            },
            success: function(data) {
                // Append the new data to the table
                table.rows.add(data.data).draw(false);
            },
            error: function() {
                console.log("Error fetching data");
            }
        });
    }

  });
</script>

</html>
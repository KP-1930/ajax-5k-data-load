<!DOCTYPE html>

<html>

<head>

    <title> Datatables </title>

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

    <h1>Datatables</h1>

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
                // Additional data if needed
            }
        },

        // Custom length menu with "All" option
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'slug', name: 'slug'},
            {data: 'detail', name: 'detail'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],

        pageLength: 100,  // Load 100 records at a time
        scrollY: "3000px",  // Enable vertical scroll
        scrollCollapse: true,
        deferRender: true,
        scroller: true,
    });

    var autoScrollInterval;

    // Event listener for processing state (show "processing..." indicator)
    table.on('processing.dt', function (e, settings, processing) {
        if (processing) {
            // Start auto-scrolling when "processing..." is shown
            startAutoScroll();
        } else {
            // Stop auto-scrolling once data is loaded
            clearInterval(autoScrollInterval);
        }
    });

    function startAutoScroll() {
        autoScrollInterval = setInterval(function () {
            var scrollBody = $('.dataTables_scrollBody');
            var scrollTop = scrollBody.scrollTop();
            var scrollHeight = scrollBody[0].scrollHeight;
            var clientHeight = scrollBody[0].clientHeight;
            
            // Scroll down by 100 pixels every 500ms
            scrollBody.scrollTop(scrollTop + 100);

            // Stop scrolling once we've hit the bottom of the table
            if (scrollTop + clientHeight >= scrollHeight) {
                clearInterval(autoScrollInterval);
            }
        }, 500); // Adjust the interval speed as needed
    }

  });
</script>



</html>
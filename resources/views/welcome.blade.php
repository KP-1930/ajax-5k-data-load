<form action="{{ route('fill.pdf') }}" method="POST">
    @csrf
    <input type="text" name="name" placeholder="Name">
    <input type="email" name="email" placeholder="Email">
    <button type="submit">Submit</button>
</form>

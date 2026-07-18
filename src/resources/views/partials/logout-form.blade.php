<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="btn btn--secondary btn--sm">Log out</button>
</form>

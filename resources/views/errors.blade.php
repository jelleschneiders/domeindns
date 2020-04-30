@if ($errors->any())
    <div class="mb-4">
        <div class="card bg-danger text-white shadow">
            <div class="card-body">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif

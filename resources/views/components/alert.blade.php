<div>
    @if ($errors->any())
        <div class="alert alert-{{ $type }} d-flex flex-column">
            <ul>
                @foreach ($errors->all() as $error)
                    <small class="text-white my-2">{{ $error }}</small>
                @endforeach
            </ul>
        </div>
    @endif
    <!-- Nothing in life is to be feared, it is only to be understood. Now is the time to understand more, so that we may fear less. - Marie Curie -->
</div>

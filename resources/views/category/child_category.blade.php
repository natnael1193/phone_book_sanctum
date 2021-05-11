<li><a href="{{ route('category.edit', $childCategory->id) }}">{{ $child_category->name }}</a></li>
@if ($child_category->categories)

 <ul>
        @foreach ($child_category->categories as $childCategory)
            @include('category.child_category', ['child_category' => $childCategory])
            {{-- <button type="btn btn-primary">Edit</button> --}}
        @endforeach
    </ul>
@endif
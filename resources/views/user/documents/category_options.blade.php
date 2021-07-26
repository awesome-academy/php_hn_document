@foreach ($categories as $category)
    <option value="{{ $category->id }}">
        @for ($i = 0; $i < $level; $i++)
            <span>&nbsp;</span>
        @endfor
    {{ $category->name }}
    </option>
    @includeWhen ($category->childCategories->count(), 'user.documents.category_options', [
        'categories' => $category->childCategories,
        'level' => $level+1,
    ])
@endforeach

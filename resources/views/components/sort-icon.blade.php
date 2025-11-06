@if ($sortField !== $field)
    <span></span>
@elseIf ($sortAsc)
    <span>
        <i class="fa-solid fa-sort-up"></i>
    </span>
@else
    <span>
        <i class="fa-solid fa-sort-down"></i>
    </span>
@endif
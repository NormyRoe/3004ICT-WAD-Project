
<x-confirm-delete
    :title="'Delete Tree Type'"
    :message="'Are you sure you want to delete this Tree Type?'"
    :itemTitle="'Tree Type: ' . $tree_type->name"
    :details="[
        'ID' => $tree_type->id,
        'Type' => $tree_type->name,
    ]"
    :deleteRoute="route('tree_types.destroy', $tree_type->id)"
    :cancelRoute="route('trees.index')"
    :name="auth()->user()->first_name"
/>

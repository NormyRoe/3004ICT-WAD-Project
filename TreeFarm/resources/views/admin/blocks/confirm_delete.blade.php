
<x-confirm-delete
    :title="'Delete Block'"
    :message="'Are you sure you want to delete this Block?'"
    :itemTitle="'Block: ' . $block->name"
    :details="[
        'ID' => $block->id,
        'Block' => $block->name,
    ]"
    :deleteRoute="route('blocks.destroy', $block->id)"
    :cancelRoute="route('locations.index')"
    :name="auth()->user()->first_name"
/>

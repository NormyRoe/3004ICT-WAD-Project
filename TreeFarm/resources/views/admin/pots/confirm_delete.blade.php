
<x-confirm-delete
    :title="'Delete Pot Size'"
    :message="'Are you sure you want to delete this Pot Size?'"
    :itemTitle="'Pot Size: ' . $pot_size->size"
    :details="[
        'ID' => $pot_size->id,
        'Size' => $pot_size->size,
    ]"
    :deleteRoute="route('pot_sizes.destroy', $pot_size->id)"
    :cancelRoute="route('pot_sizes.index')"
    :name="$name"
/>

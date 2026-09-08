
<x-confirm-delete
    :title="'Delete Area'"
    :message="'Are you sure you want to delete this Area?'"
    :itemTitle="'Area: ' . $area->name"
    :details="[
        'ID' => $area->id,
        'Area' => $area->name,
    ]"
    :deleteRoute="route('areas.destroy', $area->id)"
    :cancelRoute="route('locations.index')"
    :name="auth()->user()->first_name"
/>

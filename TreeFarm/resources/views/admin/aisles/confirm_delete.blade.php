
<x-confirm-delete
    :title="'Delete Aisle'"
    :message="'Are you sure you want to delete this Aisle?'"
    :itemTitle="'Aisle: ' . $aisle->name"
    :details="[
        'ID' => $aisle->id,
        'Aisle' => $aisle->name,
    ]"
    :deleteRoute="route('aisles.destroy', $aisle->id)"
    :cancelRoute="route('locations.index')"
    :name="auth()->user()->first_name"
/>

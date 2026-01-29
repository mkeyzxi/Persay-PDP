<div>
    <h1>download project</h1>
<button wire:click="export" class="w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
        Export Excel
    </button>
    <div class="flex gap-2 mb-4">
        <select name="selectedStatus" id="selectedStatus" wire:model="selectedStatus" class="input input-bordered">
            <option value="SEMUA">SEMUA</option>
            <option value="OPEN">OPEN</option>
            <option value="CLOSED">CLOSED</option>
            <option value="DRAFT">DRAFT</option>

    </div>


</div>

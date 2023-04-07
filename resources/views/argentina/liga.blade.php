<x-template-dashboard active="argentina.liga">
	<div class="w-full p-7">
        <h1 class="text-3xl mb-4">{{ 'Liga Argentina' }}</h1>

        <x-alert></x-alert>

        <div class="bg-white border rounded shadow p-5 text-lg">
            <div id="wg-api-football-games"
				data-host="v3.football.api-sports.io"
				data-key="76e449a048284c4ad2336531b8c06ab2"
				data-date="{{ now('Y-m-d') }}"
				data-league="128"
				data-season="{{ now('Y') }}"
				data-theme=""
				data-refresh="15"
				data-show-toolbar="true"
				data-show-errors="false"
				data-show-logos="true"
				data-modal-game="true"
				data-modal-standings="true"
				data-modal-show-logos="true">
			</div>
        </div>
    </div>
</x-template-dashboard>
